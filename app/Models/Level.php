<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    /*
    |--------------------------------------------------------------------------
    | ORM Relations
    |--------------------------------------------------------------------------
    */
    public function weeks()
    {
        return $this->belongsToMany(Week::class, 'exercise_relations', 'level_id', 'week_id')->withPivot('week_id');
    }
    /*
    |--------------------------------------------------------------------------
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */
    // 
}
