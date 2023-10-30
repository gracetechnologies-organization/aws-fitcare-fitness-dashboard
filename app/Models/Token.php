<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * This code is NOT IN USE right now but, we need to keep it
 * In future, if we ever required this "token" module 
 * Then, please remove this comment
 */


class Token extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id',
        'token'
    ];

    /*
    |--------------------------------------------------------------------------
    | ORM Relations
    |--------------------------------------------------------------------------
    */

    public function categories()
    {
        // return $this->hasOne(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */
}
