<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FocusedArea extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
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
    public static function insertInfo(string $focused_area) 
    {
        return self::create([
            'name' => $focused_area
        ]);
    }

    public static function updatedInfo(int $id, string $focused_area)
    {
        return self::where('id', '=', $id)
        ->update(['name' => $focused_area]);
    }

    public static function deleteInfo(int $id)
    {
        return self::find($id)->forceDelete();
    }

    public static function getPaginatedInfo(string $search)
    {   
        return self::where('name', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    }

    public static function getAll()
    {   
        return self::all();
    }
}
