<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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

    /*
    |--------------------------------------------------------------------------
    | ORM Relations
    |--------------------------------------------------------------------------
    */

    public function exerciseRelations()
    {
        return $this->hasMany(ExerciseRelation::class, 'ex_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'exercise_relations', 'ex_id', 'cat_id')->withPivot('cat_id');
    }

    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class, 'exercise_relations', 'ex_id', 'sub_cat_id')->withPivot('cat_id');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'exercise_relations', 'ex_id', 'level_id')->withPivot('cat_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'exercise_relations', 'ex_id', 'program_id')->withPivot('cat_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */

    /**
     * These methods will return the given collection
     * In a associative array format
     * @return object
     * @author Muhammad Abdullah Mirza
     */
    public static function getCategoriesArray(Collection $collection): object
    {
        return $collection->map(function ($category) {
            return [
                'ex_cat_id' => $category->id,
                'ex_cat_name' => $category->name,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            ];
        });
    }

    public static function getSubCategoriesArray(Collection $collection): object
    {
        return $collection->map(function ($sub_categories) {
            return [
                'ex_sub_cat_id' => $sub_categories->id,
                'ex_sub_cat_name' => $sub_categories->name,
                'ex_sub_cat_parent_category_id' => $sub_categories->category_id,
                'created_at' => $sub_categories->created_at,
                'updated_at' => $sub_categories->updated_at,
            ];
        });
    }

    public static function getLevelsArray(Collection $collection): object
    {
        return $collection->map(function ($level) {
            return [
                'ex_level_id' => $level->id,
                'ex_level_name' => $level->name,
                'created_at' => $level->created_at,
                'updated_at' => $level->updated_at,
            ];
        });
    }

    public static function getProgramsArray(Collection $collection): object
    {
        return $collection->map(function ($program) {
            return [
                'ex_prog_id' => $program->id,
                'ex_prog_name' => $program->name,
                'created_at' => $program->created_at,
                'updated_at' => $program->updated_at,
            ];
        });
    }

    public static function getDaysArray(Collection $collection): object
    {
        return $collection->map(function ($relation) {
            return [
                'ex_relation_id' => $relation->id,
                'ex_id' => $relation->ex_id,
                'cat_id' => $relation->cat_id,
                'level_id' => $relation->level_id,
                'program_id' => $relation->program_id,
                'from_day' => $relation->from_day,
                'till_day' => $relation->till_day,
                'created_at' => $relation->created_at,
                'updated_at' => $relation->updated_at,
            ];
        });
    }

    public static function getExercises(string $search)
    {
        return Exercise::where('ex_name', 'like', '%' . $search . '%')
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public static function getExercisesOfCategory(int $cat_id, string $search)
    {
        return Exercise::whereHas('categories', function ($query) use ($cat_id) {
            $query->where('categories.id', $cat_id);
        })
            ->where('ex_name', 'like', '%' . $search . '%')
            ->where('is_active', 1)
            ->paginate(10);
    }

    public static function getExercisesOfSubCategory(int $cat_id, int $sub_cat_id, string $search)
    {
        return Exercise::whereHas('subCategories', function ($query) use ($cat_id, $sub_cat_id) {
            $query->where('sub_categories.id', $sub_cat_id)
                ->where('sub_categories.category_id', $cat_id);
        })
            ->where('ex_name', 'like', '%' . $search . '%')
            ->where('is_active', 1)
            ->paginate(10);
    }

    public static function getExercisesOfProgram(int $program_id, string $search)
    {
        return Exercise::whereHas('programs', function ($query) use ($program_id) {
            $query->where('programs.id', $program_id);
        })
            ->where('ex_name', 'like', '%' . $search . '%')
            ->where('is_active', 1)
            ->paginate(10);
    }

    public static function totalExercisesOfCategory(int $cat_id)
    {
        return Exercise::whereHas('exerciseRelations', function ($query) use ($cat_id) {
            $query->where('exercise_relations.cat_id', $cat_id);
        })
            ->where('is_active', 1)
            ->count();
    }

    public static function totalExercisesOfCategoryLevel(int $cat_id, int $level_id)
    {
        return Exercise::whereHas('exerciseRelations', function ($query) use ($cat_id, $level_id) {
            $query->where('exercise_relations.cat_id', $cat_id)
                ->where('exercise_relations.level_id', $level_id);
        })
            ->where('is_active', 1)
            ->count();
    }

    public static function totalExercisesOfSubCategory(int $sub_cat_id)
    {
        return Exercise::whereHas('exerciseRelations', function ($query) use ($sub_cat_id) {
            $query->where('exercise_relations.sub_cat_id', $sub_cat_id);
        })
            ->where('is_active', 1)
            ->count();
    }
    /*
    |--------------------------------------------------------------------------
    | API Functions
    |--------------------------------------------------------------------------
    */

    /**
     * @author Muhammad Abdullah Mirza
     */
    public static function fetchAllNeckWorkouts()
    {
        $data = [];
        $exercises = Exercise::whereHas('exerciseRelations', function ($query) {
            $query->whereIn('cat_id', [10, 11, 12]);
        })
            ->with([
                'categories' => function ($query) {
                    $query->whereIn('cat_id', [10, 11, 12]);
                }, 'programs' => function ($query) {
                    $query->whereIn('cat_id', [10, 11, 12]);
                }
            ])
            ->where('is_active', 1)
            ->orderByDesc('created_at')
            ->get();

        foreach ($exercises as $single_exercise) {
            array_push($data, (object)
            [
                'ex_id' => $single_exercise->id,
                'ex_title' => $single_exercise->ex_name,
                'ex_description' => $single_exercise->ex_description,
                'ex_duration' => $single_exercise->ex_duration,
                'video_thumbnail' => asset('storage/images/' . str_replace(" ", "%20", $single_exercise->ex_thumbnail_url)),
                'video_url_path' => asset('storage/videos/' . str_replace(" ", "%20", $single_exercise->ex_video_url)),
                'is_active' => $single_exercise->is_active,
                'created_at' => $single_exercise->created_at,
                'updated_at' => $single_exercise->updated_at,
                'deleted_at' => $single_exercise->deleted_at,
                'category' => static::getCategoriesArray($single_exercise->categories),
                'programs' => static::getProgramsArray($single_exercise->programs)
            ]);
        }
        return $data;
    }
    /**
     * @author Muhammad Abdullah Mirza
     */
    public static function fetchExercisesByCatId(int $cat_id)
    {
        $data = [];
        $exercises = Exercise::whereHas('exerciseRelations', function ($query) use ($cat_id) {
            $query->where('cat_id', $cat_id);
        })
            ->with([
                'exerciseRelations' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id);
                }, 'categories' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id)->distinct();
                }, 'subCategories' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id);
                }, 'levels' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id);
                }, 'programs' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id);
                }
            ])
            ->where('is_active', 1)
            ->orderByDesc('created_at')
            ->get();

        foreach ($exercises as $single_exercise) {
            array_push($data, (object)
            [
                'ex_id' => $single_exercise->id,
                'ex_title' => $single_exercise->ex_name,
                'ex_description' => $single_exercise->ex_description,
                'ex_duration' => $single_exercise->ex_duration,
                'video_thumbnail' => asset('storage/images/' . str_replace(" ", "%20", $single_exercise->ex_thumbnail_url)),
                'video_url_path' => asset('storage/videos/' . str_replace(" ", "%20", $single_exercise->ex_video_url)),
                'is_active' => $single_exercise->is_active,
                'created_at' => $single_exercise->created_at,
                'updated_at' => $single_exercise->updated_at,
                'deleted_at' => $single_exercise->deleted_at,
                'category' => static::getCategoriesArray($single_exercise->categories),
                'sub_category' => static::getSubCategoriesArray($single_exercise->subCategories),
                'levels' => static::getLevelsArray($single_exercise->levels),
                'programs' => static::getProgramsArray($single_exercise->programs),
                'days' => static::getDaysArray($single_exercise->exerciseRelations)
            ]);
        }
        return $data;
    }
    /**
     * @author Muhammad Abdullah Mirza
     */
    public static function fetchExercisesByGivenParams(object $req)
    {
        $data = [];
        $cat_id = (int) $req->query('cat_id');
        $sub_cat_id = (int) $req->query('sub_cat_id');
        $level_id = (int) $req->query('level_id');
        $program_id = (int) $req->query('program_id');
        $from_day = (int) $req->query('from_day');
        $exercises = Exercise::whereHas('exerciseRelations', function ($query) use ($cat_id, $sub_cat_id, $level_id, $program_id, $from_day) {
            $query->where('cat_id', $cat_id)
                ->when($sub_cat_id, function ($query, $sub_cat_id) {
                    return $query->where('sub_cat_id', $sub_cat_id);
                })
                ->when($level_id, function ($query, $level_id) {
                    return $query->where('level_id', $level_id);
                })
                ->when($program_id, function ($query, $program_id) {
                    return $query->where('program_id', $program_id);
                })
                ->when($from_day, function ($query, $from_day) {
                    return $query->where('from_day', '<=', $from_day)
                        ->where('till_day', '>=', $from_day);
                });
        })
            ->with([
                'exerciseRelations' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id);
                },
                'categories' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id)->distinct();
                },
                'subCategories' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id);
                },
                'levels' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id);
                },
                'programs' => function ($query) use ($cat_id) {
                    $query->where('cat_id', $cat_id);
                }
            ])
            ->where('is_active', 1)
            ->orderByDesc('created_at')
            ->get();

        foreach ($exercises as $single_exercise) {
            array_push($data, (object)
            [
                'ex_id' => $single_exercise->id,
                'ex_title' => $single_exercise->ex_name,
                'ex_description' => $single_exercise->ex_description,
                'ex_duration' => $single_exercise->ex_duration,
                'video_thumbnail' => asset('storage/images/' . str_replace(" ", "%20", $single_exercise->ex_thumbnail_url)),
                'video_url_path' => asset('storage/videos/' . str_replace(" ", "%20", $single_exercise->ex_video_url)),
                'is_active' => $single_exercise->is_active,
                'created_at' => $single_exercise->created_at,
                'updated_at' => $single_exercise->updated_at,
                'deleted_at' => $single_exercise->deleted_at,
                'category' => static::getCategoriesArray($single_exercise->categories),
                'sub_category' => static::getSubCategoriesArray($single_exercise->subCategories),
                'levels' => static::getLevelsArray($single_exercise->levels),
                'programs' => static::getProgramsArray($single_exercise->programs),
                'days' => static::getDaysArray($single_exercise->exerciseRelations)
            ]);
        }
        return $data;
    }
}
