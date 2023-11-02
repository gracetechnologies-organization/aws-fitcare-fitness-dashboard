<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ImageManipulationClass;

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

    public static function getInfoByID(int $id)
    {
        return self::with('focused_areas')
            ->where('id', '=', $id)->first();
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
