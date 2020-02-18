<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
// use Carbon\Carbon;

class GeneralHelper {

    public static function send_response(int $code, string $message, $data) : JsonResponse {
        if ($code != 200 && $code != 201) {
            return response()->json([
                "status" => $code,
                "message" => $message,
                "errors" => $data
            ], $code);
        } else {
            return response()->json([
                "status" => $code,
                "message" => $message,
                "data" => $data
            ], $code);
        }
    }

    // public static function create_logger_crud(string $operation, string $model, string $content, string $desc = '') {
    //     $dataLogger['model'] = $model;
    //     $dataLogger['method'] = __METHOD__;
    //     $dataLogger['line_number'] = __LINE__;
    //     $dataLogger['class'] = __CLASS__;
    //     $dataLogger['file'] = __FILE__;
    //     $dataLogger['dir'] = __DIR__;
    //     $dataLogger['namespace'] = __NAMESPACE__;
    //     $dataLogger['operation'] = $operation;
    //     $dataLogger['content'] = $content;
    //     $dataLogger['desc'] = $desc;
    //     $dataLogger['log_date'] = Carbon::now()->format('Y-m-d');
    //     $dataLogger['log_time'] = Carbon::now()->format('H:i:s');
    //     return $dataLogger;
    // }

}