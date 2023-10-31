<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class VideoManipulationClass
{
    public static function getVideoURL(object $video, string $path)
    {
        $video_name = Carbon::now()->timestamp . "_" . str_replace(" ", "_", $video->getClientOriginalName());
        Storage::disk('public')->putFileAs($path, $video, $video_name);
        return $video_name;
    }
}
