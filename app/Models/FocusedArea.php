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

    public static function updateInfo(int $id, string $focused_area)
    {
        return self::where('id', '=', $id)
            ->update(['name' => $focused_area]);
    }

    public static function deleteInfo(int $id)
    {
        return self::find($id)->forceDelete();
    }

    public static function getInfoByID(int $id)
    {
        return self::where('id', '=', $id)->first();
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
