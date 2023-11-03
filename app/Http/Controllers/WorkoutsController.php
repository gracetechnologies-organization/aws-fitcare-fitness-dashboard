<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Services\CustomResponseClass;
use App\Services\PaginationManipulationClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class WorkoutsController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @author Muhammad Abdullah Mirza
     */
    public function list(Request $req)
    {
        try {
            // $validator = Validator::make($req->all(), [
            //     'items_per_page' => 'required|integer'
            // ]);
            // if ($validator->fails()) {
            //     return CustomResponseClass::JsonResponse(
            //         [],
            //         config('messages.FAILED_CODE'),
            //         $validator->errors(),
            //         config('messages.HTTP_UNPROCESSABLE_DATA')
            //     );
            // }

            if ($req->id) {
                $data = Cache::rememberForever('listWorkout' . $req->id, function () use ($req) {
                    return  Workout::getInfoByIDForApi($req->id);
                });
                return CustomResponseClass::JsonResponse(
                    (empty($data)) ? [] : $data,
                    config('messages.SUCCESS_CODE'),
                    (empty($data)) ? config('messages.NO_RECORD') : '',
                    config('messages.HTTP_SUCCESS_CODE')
                );
            }
            $workouts = Workout::getPaginatedInfoForApi(10);
            // dd($workouts);
            $data = $workouts->groupBy('workout_id')->map(function ($workout) {
                return [
                    'id' => $workout[0]->workout_id,
                    'name' => $workout[0]->workout_name,
                    'gender' => $workout[0]->workout_gender,
                    'thumbnail_url' => asset('uploads/images/workouts/' . $workout[0]->workout_thumbnail_url),
                    'levels' => $workout->groupBy('level_id')->map(function ($level) {
                        return [
                            'id' => $level[0]->level_id,
                            'name' => $level[0]->level_name,
                            'weeks' => $level->map(function ($week) {
                                return [
                                    'id' => $week->week_id,
                                    'name' => $week->week_name,
                                ];
                            })->unique(),
                        ];
                    })->values(),
                ];
            });
            // dd($data);
            return CustomResponseClass::JsonResponseExtention(
                $data->values(),
                config('messages.SUCCESS_CODE'),
                (empty($data)) ? config('messages.NO_RECORD') : '',
                'pagination',
                PaginationManipulationClass::getPaginationKeys($workouts),
                config('messages.HTTP_SUCCESS_CODE')
            );
        } catch (Exception $error) {
            report($error);
            return CustomResponseClass::JsonResponse(
                [],
                config('messages.FAILED_CODE'),
                $error->getMessage(),
                config('messages.HTTP_SERVER_ERROR_CODE')
            );
        }
    }
}
