<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutFocusedArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_id',
        'focused_area_id'
    ];
     /*
    |--------------------------------------------------------------------------
    | ORM Relations
    |--------------------------------------------------------------------------
    */
    //

    /*
    |--------------------------------------------------------------------------
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */
    public static function insertInfo(int $workout_id, int $focused_area_id) 
    {
        return self::create([
            'workout_id' => $workout_id,
            'focused_area_id' => $focused_area_id
        ]);
    }
}
