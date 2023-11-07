<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class ArrayManipulationClass
{
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
                'ex_cat_name' => $category->name
            ];
        });
    }

    public static function getWorkoutsArray(Collection $collection): object
    {
        return $collection->map(function ($workout) {
            return [
                'workout_id' => $workout->id,
                'workout_name' => $workout->name
            ];
        });
    }

    public static function getSubCategoriesArray(Collection $collection): object
    {
        return $collection->map(function ($sub_categories) {
            return [
                'ex_sub_cat_id' => $sub_categories->id,
                'ex_sub_cat_name' => $sub_categories->name,
                'ex_sub_cat_parent_category_id' => $sub_categories->category_id
            ];
        });
    }

    public static function getLevelsArray(Collection $collection): object
    {
        return $collection->map(function ($level) {
            return [
                'level_id' => $level->id,
                'level_name' => $level->name
            ];
        });
    }

    public static function getWeeksArray(Collection $collection): object
    {
        return $collection->map(function ($week) {
            return [
                'week_id' => $week->id,
                'week_name' => $week->name
            ];
        });
    }

    public static function getProgramsArray(Collection $collection): object
    {
        return $collection->map(function ($program) {
            return [
                'ex_prog_id' => $program->id,
                'ex_prog_name' => $program->name
            ];
        });
    }

    public static function getDaysArray(Collection $collection): object
    {
        return $collection->map(function ($relation) {
            return [
                'ex_relation_id' => $relation->id,
                'ex_id' => $relation->ex_id,
                'workout_id' => $relation->workout_id,
                'level_id' => $relation->level_id,
                'week_id' => $relation->week_id,
                'from_day' => $relation->from_day,
                'till_day' => $relation->till_day
            ];
        });
    }
    /**
     * @return array
     * @author Muhammad Abdullah Mirza
     */
    public static function removeFalseValues($array)
    {
        return array_filter($array, fn ($value) => $value !== false);
    }
}
