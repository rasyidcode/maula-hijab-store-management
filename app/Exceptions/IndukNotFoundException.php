<?php

namespace App\Exceptions;

use Exception;

class IndukNotFoundException extends Exception {
    
    public function report() {}

    public function render($request) {
        return response()->json([
            'status' => 404,
            'message' => 'Induk tidak dapat ditemukan!',
            'data' => null
        ], 404);
    }
}
