<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Services\ArrayManipulationClass;
use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExercisesController extends Controller
{
    /**
     * List all data w.r.t cat_id
     * @return \Illuminate\Http\JsonResponse
     * @author Muhammad Abdullah Mirza
     */
    public function listAllDataByCatId($cat_id)
    {
        try {
            return CustomResponseClass::JsonResponse(
                $data = Exercise::fetchExercisesByCatId($cat_id),
                config('messages.SUCCESS_CODE'),
                (empty($data)) ? config('messages.NO_RECORD') : '',
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
    /**
     * List all data for Neck Workout App
     * @return \Illuminate\Http\JsonResponse
     * @author Muhammad Abdullah Mirza
     */
    public function listAllDataNeckWorkout()
    {
        try {
            return CustomResponseClass::JsonResponse(
                $data = Exercise::fetchAllNeckWorkouts(),
                config('messages.SUCCESS_CODE'),
                (empty($data)) ? config('messages.NO_RECORD') : '',
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
    /**
     * List all data for any provided params 
     * @return \Illuminate\Http\JsonResponse
     * @author Muhammad Abdullah Mirza
     */
    public function list(Request $req)
    {
        try {
            $Validator = Validator::make($req->all(), [
                'workout_id' => 'required|integer',
                'level_id' => 'integer',
                'week_id' => 'integer',
                'from_day' => 'integer',
                'till_day' => 'integer'
            ]);
            if ($Validator->fails()) {
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.FAILED_CODE'),
                    $Validator->errors(),
                    config('messages.HTTP_UNPROCESSABLE_DATA')
                );
            }
            $exercises = Exercise::getPaginatedInfoByParamsForApi($req->workout_id, $req->level_id, $req->week_id, $req->from_day, $req->till_day);
            $data = [];
            foreach ($exercises as $single_exercise) {
                $data[] = [
                    'ex_id' => $single_exercise->id,
                    'ex_title' => $single_exercise->ex_name,
                    'ex_description' => $single_exercise->ex_description,
                    'ex_duration' => $single_exercise->ex_duration,
                    'ex_gender' => $single_exercise->ex_gender,
                    'video_thumbnail' => asset('uploads/images/exercises/' . $single_exercise->ex_thumbnail_url),
                    'video_url_path' => asset('uploads/videos/exercises/' . $single_exercise->ex_video_url),
                    'is_active' => $single_exercise->is_active,
                    // 'category' => ArrayManipulationClass::getCategoriesArray($single_exercise->categories),
                    // 'sub_category' => ArrayManipulationClass::getSubCategoriesArray($single_exercise->subCategories),
                    'workouts' => ArrayManipulationClass::getWorkoutsArray($single_exercise->workouts),
                    'levels' => ArrayManipulationClass::getLevelsArray($single_exercise->levels),
                    'weeks' => ArrayManipulationClass::getWeeksArray($single_exercise->weeks),
                    // 'programs' => ArrayManipulationClass::getProgramsArray($single_exercise->programs),
                    'days' => ArrayManipulationClass::getDaysArray($single_exercise->exerciseRelations)
                ];
            }
            return CustomResponseClass::JsonResponse(
                $data,
                config('messages.SUCCESS_CODE'),
                (empty($data)) ? config('messages.NO_RECORD') : '',
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
