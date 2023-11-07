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
            // dd($req->focused_areas_ids);
            $validator = Validator::make($req->all(), [
                'id' => 'integer',
                'focused_areas_ids' => 'array',
                'gender' => 'required|string|regex:/^[A-Za-z\s]+$/',
            ]);
            // $customMessages = [
            //     'gender.required_if' => 'The gender field is required when a focused area is specified.',
            // ];
            // $validator->setCustomMessages($customMessages);
            if ($validator->fails()) {
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.FAILED_CODE'),
                    $validator->errors(),
                    config('messages.HTTP_UNPROCESSABLE_DATA')
                );
            }

            if ($req->id) {
                $data = Cache::rememberForever('listWorkout' . $req->id, function () use ($req) {
                    $workout = Workout::getInfoByIDForApi($req->id);
                    return $workout->groupBy('workout_id')->map(function ($workout) {
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
                });
                return CustomResponseClass::JsonResponse(
                    ($data->isEmpty()) ? [] : $data->values(),
                    config('messages.SUCCESS_CODE'),
                    ($data->isEmpty()) ? config('messages.NO_RECORD') : '',
                    config('messages.HTTP_SUCCESS_CODE')
                );
            }

            if ($req->focused_areas_ids) {
                $workouts = Workout::getPaginatedInfoByParamsForApi($req->focused_areas_ids, $req->gender);
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
                return CustomResponseClass::JsonResponseExtention(
                    ($data->isEmpty()) ? [] : $data->values(),
                    config('messages.SUCCESS_CODE'),
                    ($data->isEmpty()) ? config('messages.NO_RECORD') : '',
                    'pagination',
                    ($data->isEmpty()) ? [] : PaginationManipulationClass::getPaginationKeys($workouts),
                    config('messages.HTTP_SUCCESS_CODE')
                );
            }

            $workouts = Workout::getPaginatedInfoForApi();
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
            return CustomResponseClass::JsonResponseExtention(
                ($data->isEmpty()) ? [] : $data->values(),
                config('messages.SUCCESS_CODE'),
                ($data->isEmpty()) ? config('messages.NO_RECORD') : '',
                'pagination',
                ($data->isEmpty()) ? [] : PaginationManipulationClass::getPaginationKeys($workouts),
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
