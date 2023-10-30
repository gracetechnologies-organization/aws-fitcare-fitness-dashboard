<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ImageManipulationClass
{
    public static function getImgURL(object $image, string $path)
    {
        $img_name = Carbon::now()->timestamp . "_" . str_replace(" ", "_", $image->getClientOriginalName());
        Storage::disk('public')->putFileAs($path, $image, $img_name);
        return $img_name;
    }
}
