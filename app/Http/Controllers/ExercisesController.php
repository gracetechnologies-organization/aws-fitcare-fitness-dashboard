<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\RemoteConfig;
use Kreait\Firebase\RemoteConfig\Parameter;
use Kreait\Firebase\RemoteConfig\ParameterGroup;
use Kreait\Firebase\RemoteConfig\Template;
use Kreait\Firebase\Value;

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
    public function listAllDataByGivenParams(Request $req)
    {
        try {
            $Validator = Validator::make($req->all(), [
                'cat_id' => 'required|integer'
            ]);
            if ($Validator->fails()) {
                return CustomResponseClass::JsonResponse(
                    [],
                    config('messages.FAILED_CODE'),
                    $Validator->errors(),
                    config('messages.HTTP_UNPROCESSABLE_DATA')
                );
            }
            return CustomResponseClass::JsonResponse(
                $data = Exercise::fetchExercisesByGivenParams($req),
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

    // public function fireBaseRemoteConfig()
    // {
    //     $token = '999e73ce-61e0-431b-84c5-dddc01bf9947';

    //     $parameter = Parameter::named('token')->withDefaultValue($token);
    //     $template = Template::new()->withParameter($parameter);

    //     $remoteConfig = Firebase::project('app1')->remoteConfig(); 
    //     $remoteConfig->publish($template);
    // }

    // public function fireBaseRemoteConfigParamGroup()
    // {
    //     $parameterGroup = ParameterGroup::named('Token')->withParameter(Parameter::named('t')->withDefaultValue('blue'));

    //     $template = Template::new()->withParameterGroup($parameterGroup); 

    //     $remoteConfig = Firebase::project('app1')->remoteConfig();
    //     $remoteConfig->publish($template);
    // }

    // public function fireBaseRemoteConfigRemove()
    // {
    //     $token = 'token';
    //     $template = Template::new()->withRemovedParameter($token);

    //     $remoteConfig = Firebase::project('app1')->remoteConfig();
    //     $remoteConfig->publish($template);
    // }
}
