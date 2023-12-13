<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ex_name',
        'ex_description',
        'ex_duration',
        'ex_gender',
        'ex_thumbnail_url',
        'ex_video_url',
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
    public function exerciseRelations()
    {
        return $this->hasMany(ExerciseRelation::class, 'ex_id');
    }

    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class, 'exercise_relations', 'ex_id', 'cat_id')->withPivot('cat_id');
    // }

    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'exercise_relations', 'ex_id', 'workout_id')->withPivot('workout_id');
    }

    // public function subCategories()
    // {
    //     return $this->belongsToMany(SubCategory::class, 'exercise_relations', 'ex_id', 'sub_cat_id')->withPivot('cat_id');
    // }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'exercise_relations', 'ex_id', 'level_id')->withPivot('workout_id');
    }

    public function weeks()
    {
        return $this->belongsToMany(Week::class, 'exercise_relations', 'ex_id', 'week_id')->withPivot('workout_id');
    }

    // public function programs()
    // {
    //     return $this->belongsToMany(Program::class, 'exercise_relations', 'ex_id', 'program_id')->withPivot('cat_id');
    // }

    /*
    |--------------------------------------------------------------------------
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */
    public static function getRelationsInfoByID(int $id)
    {
        return self::select('exercise_relations.id as rel_id', 'exercises.id as ex_id', 'workouts.id as workout_id', 'workouts.name as workout_name', 'levels.id as level_id', 'levels.name as level_name', 'weeks.id as week_id', 'weeks.name as week_name', 'exercise_relations.from_day', 'exercise_relations.till_day')
            ->leftJoin('exercise_relations', 'exercise_relations.ex_id', '=', 'exercises.id')
            ->leftJoin('workouts', 'workouts.id', '=', 'exercise_relations.workout_id')
            ->leftJoin('levels', 'levels.id', '=', 'exercise_relations.level_id')
            ->leftJoin('weeks', 'weeks.id', '=', 'exercise_relations.week_id')
            ->where('exercises.id', $id)
            ->get();
    }

    public static function getInfoByID(int $id)
    {
        return self::find($id);
    }

    public static function getAllTrashed(string $search)
    {
        return self::onlyTrashed()->where('ex_name', 'like', '%' . $search . '%')
            ->where('is_active', 0)
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
    }

    public static function getAll(string $search)
    {
        return self::where('ex_name', 'like', '%' . $search . '%')
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
    /*
    |--------------------------------------------------------------------------
    | API Functions
    |--------------------------------------------------------------------------
    */
    /**
     * @author Muhammad Abdullah Mirza
     */
    public static function getPaginatedInfoByParamsForApi(int $workout_id, int|null $level_id, int|null $week_id, int|null $from_day, int|null $till_day)
    {
        return self::whereHas('exerciseRelations', function ($query) use ($workout_id, $level_id, $week_id, $from_day, $till_day) {
            $query->where('workout_id', $workout_id)
                ->when($level_id, function ($query, $level_id) {
                    return $query->where('level_id', $level_id);
                })
                ->when($week_id, function ($query, $week_id) {
                    return $query->where('week_id', $week_id);
                })
                ->when($from_day && $till_day, function ($query) use ($from_day, $till_day) {
                    return $query->where('from_day', '=', $from_day)
                        ->where('till_day', '>=', $till_day);
                });
        })
            // ->with([
            //     'exerciseRelations' => function ($query) use ($workout_id) {
            //         $query->where('workout_id', $workout_id);
            //     },
            //     'workouts' => function ($query) use ($workout_id) {
            //         $query->where('workout_id', $workout_id)->distinct();
            //     },
            //     'levels' => function ($query) use ($workout_id) {
            //         $query->where('workout_id', $workout_id)->distinct();
            //     },
            //     'weeks' => function ($query) use ($workout_id) {
            //         $query->where('workout_id', $workout_id);
            //     }
            // ])
            ->where('is_active', 1)
            ->orderByDesc('created_at')
            ->get();
    }

    // public static function getExercisesOfCategory(int $cat_id, string $search)
    // {
    //     return self::whereHas('categories', function ($query) use ($cat_id) {
    //         $query->where('categories.id', $cat_id);
    //     })
    //         ->where('ex_name', 'like', '%' . $search . '%')
    //         ->where('is_active', 1)
    //         ->paginate(10);
    // }

    // public static function getExercisesOfSubCategory(int $cat_id, int $sub_cat_id, string $search)
    // {
    //     return self::whereHas('subCategories', function ($query) use ($cat_id, $sub_cat_id) {
    //         $query->where('sub_categories.id', $sub_cat_id)
    //             ->where('sub_categories.category_id', $cat_id);
    //     })
    //         ->where('ex_name', 'like', '%' . $search . '%')
    //         ->where('is_active', 1)
    //         ->paginate(10);
    // }

    // public static function getExercisesOfProgram(int $program_id, string $search)
    // {
    //     return self::whereHas('programs', function ($query) use ($program_id) {
    //         $query->where('programs.id', $program_id);
    //     })
    //         ->where('ex_name', 'like', '%' . $search . '%')
    //         ->where('is_active', 1)
    //         ->paginate(10);
    // }

    // public static function totalExercisesOfCategory(int $cat_id)
    // {
    //     return self::whereHas('exerciseRelations', function ($query) use ($cat_id) {
    //         $query->where('exercise_relations.cat_id', $cat_id);
    //     })
    //         ->where('is_active', 1)
    //         ->count();
    // }

    // public static function totalExercisesOfCategoryLevel(int $cat_id, int $level_id)
    // {
    //     return self::whereHas('exerciseRelations', function ($query) use ($cat_id, $level_id) {
    //         $query->where('exercise_relations.cat_id', $cat_id)
    //             ->where('exercise_relations.level_id', $level_id);
    //     })
    //         ->where('is_active', 1)
    //         ->count();
    // }

    // public static function totalExercisesOfSubCategory(int $sub_cat_id)
    // {
    //     return self::whereHas('exerciseRelations', function ($query) use ($sub_cat_id) {
    //         $query->where('exercise_relations.sub_cat_id', $sub_cat_id);
    //     })
    //         ->where('is_active', 1)
    //         ->count();
    // }
}
