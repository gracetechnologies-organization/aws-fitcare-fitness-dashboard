<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'token'
    ];

    /*
    |--------------------------------------------------------------------------
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */

    public static function getTokens(string $search)
    {
        return Category::where('name', 'like', '%' . $search . '%')
            ->whereNotNull('token')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
    }

    public static function getCategories()
    {
        return Category::orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'categories_page');
    }

    public static function searchCategories(string $search)
    {
        return Category::where('name', 'like', '%' . $search . '%')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
