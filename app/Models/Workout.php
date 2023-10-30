<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ImageManipulationClass;

class Workout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail_url'
    ];
    /*
    |--------------------------------------------------------------------------
    | ORM Relations
    |--------------------------------------------------------------------------
    */
    public function focused_areas()
    {
        return $this->belongsToMany(FocusedArea::class, 'workout_focused_areas', 'workout_id', 'focused_area_id')->withPivot('focused_area_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Helper Functions
    |--------------------------------------------------------------------------
    */
    public static function insertInfo(string $name, object $thumbnail) 
    {
        return self::create([
            'name' => $name,
            'thumbnail_url' => ImageManipulationClass::getImgURL($thumbnail, 'images/workouts')
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
        return self::with('focused_areas')
        ->where('name', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    }

    public static function getAll()
    {   
        return self::all();
    }
}
