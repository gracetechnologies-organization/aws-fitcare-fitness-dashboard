<?php

namespace App\Http\Controllers;

use App\Models\FocusedArea;
use App\Services\CustomResponseClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FocusedAreasController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @author Muhammad Abdullah Mirza
     */
    public function list(Request $req)
    {
        try {
            if ($req->id) {
                $data = Cache::rememberForever('listFocusedArea' . $req->id, function () use ($req) {
                    return  FocusedArea::getInfoByID($req->id);
                });
                return CustomResponseClass::JsonResponse(
                    (empty($data)) ? [] : $data,
                    config('messages.SUCCESS_CODE'),
                    (empty($data)) ? config('messages.NO_RECORD') : '',
                    config('messages.HTTP_SUCCESS_CODE')
                );
            }
            $data = Cache::rememberForever('listAllFocusedAreas', function () {
                // $focused_areas = FocusedArea::getAll();
                // $data = [];
                // foreach ($focused_areas as $single_index) {
                //     array_push($data, [
                //         "id" => $single_index->id,
                //         "name" => $single_index->name,
                //     ]);
                // }
                // return $data;
                return FocusedArea::getAll();
            });
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
