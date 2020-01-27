<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

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

}