<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ImageManipulationClass;
use Illuminate\Support\Facades\DB;

class Workout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'thumbnail_url'
    ];
    /**
     * The attributes that should be hidden for arrays/JSON
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /*
    |--------------------------------------------------------------------------
    | ORM Relations
    |--------------------------------------------------------------------------
    */
    public function focused_areas()
    {
        return $this->belongsToMany(FocusedArea::class, 'workout_focused_areas', 'workout_id', 'focused_area_id')->withPivot('focused_area_id');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'exercise_relations', 'workout_id', 'level_id')->withPivot('level_id');
    }
    /*
    |--------------------------------------------------------------------------
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */
    public static function insertInfo(string $name, string $gender, object $thumbnail)
    {
        return self::create([
            'name' => $name,
            'gender' => $gender,
            'thumbnail_url' => ImageManipulationClass::getImgURL($thumbnail, 'images/workouts')
        ]);
    }

    public static function updateRelation(int $workout_id, array $new_focused_areas_ids)
    {
        $workout = Workout::find($workout_id);
        // Use sync() to update or insert records in the pivot table
        // Pass "true" to detach/delete old relations from the pivot table 
        return $workout->focused_areas()->sync($new_focused_areas_ids, true);
    }

    public static function updateInfo(int $id, string $name, string $gender, object $thumbnail)
    {
        return self::where('id', '=', $id)
            ->update([
                'name' => $name,
                'gender' => $gender,
                'thumbnail_url' => ImageManipulationClass::getImgURL($thumbnail, 'images/workouts')
            ]);
    }

    public static function deleteInfo(int $id)
    {
        return self::find($id)->forceDelete();
    }

    public static function getInfoByIDForApi(int $id)
    {
        return self::select(
            'workouts.id as workout_id',
            'workouts.name as workout_name',
            'workouts.gender as workout_gender',
            'workouts.thumbnail_url as workout_thumbnail_url',
            'levels.id as level_id',
            'levels.name as level_name',
            'weeks.id as week_id',
            'weeks.name as week_name'
        )
            ->join('exercise_relations', 'workouts.id', '=', 'exercise_relations.workout_id')
            ->join('levels', 'exercise_relations.level_id', '=', 'levels.id')
            ->join('weeks', 'exercise_relations.week_id', '=', 'weeks.id')
            ->where('workouts.id', '=', $id)
            ->first();
    }

    public static function getInfoByID(int $id)
    {
        return self::with('focused_areas')
            ->where('id', '=', $id)->first();
    }

    public static function getPaginatedInfoForApi(int $items_per_page)
    {
        return self::select(
            'workouts.id as workout_id',
            'workouts.name as workout_name',
            'workouts.gender as workout_gender',
            'workouts.thumbnail_url as workout_thumbnail_url',
            'workouts.created_at',
            'levels.id as level_id',
            'levels.name as level_name',
            'weeks.id as week_id',
            'weeks.name as week_name'
        )
            ->join('exercise_relations', 'workouts.id', '=', 'exercise_relations.workout_id')
            ->join('levels', 'exercise_relations.level_id', '=', 'levels.id')
            ->join('weeks', 'exercise_relations.week_id', '=', 'weeks.id')
            ->distinct()
            ->orderBy('workouts.created_at', 'desc')
            ->paginate($items_per_page);

        // $subquery = self::select(
        //     'workouts.id as workout_id',
        //     'workouts.name as workout_name',
        //     'workouts.gender as workout_gender',
        //     'workouts.thumbnail_url as workout_thumbnail_url',
        //     'workouts.created_at',
        //     'levels.id as level_id',
        //     'levels.name as level_name',
        //     'weeks.id as week_id',
        //     'weeks.name as week_name'
        // )
        //     ->join('exercise_relations', 'workouts.id', '=', 'exercise_relations.workout_id')
        //     ->join('levels', 'exercise_relations.level_id', '=', 'levels.id')
        //     ->join('weeks', 'exercise_relations.week_id', '=', 'weeks.id')
        //     ->orderBy('workouts.created_at', 'desc');
        
        // $distinctRecords = DB::table(DB::raw("({$subquery->toSql()}) as subquery"))
        //     ->mergeBindings($subquery->getQuery())
        //     ->distinct()
        //     ->select('workout_id', 'workout_name', 'workout_gender', 'workout_thumbnail_url', 'created_at', 'level_id', 'level_name', 'week_id', 'week_name')
        //     ->paginate($items_per_page);
        
        // return $distinctRecords;
        
    }

    public static function getPaginatedInfo(string $search)
    {
        return self::with('focused_areas')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public static function getAll()
    {
        return self::all();
    }
}
