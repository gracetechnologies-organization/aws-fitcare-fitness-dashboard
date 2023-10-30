<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id'
    ];
    /*
    |--------------------------------------------------------------------------
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */
    public static function totalSubCategoriesOfCategory(int $cat_id)
    {
        return SubCategory::where('category_id', $cat_id)
            ->count();
    }
}
