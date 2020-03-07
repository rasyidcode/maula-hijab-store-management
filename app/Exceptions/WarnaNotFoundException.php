<?php

namespace App\Exceptions;

use Exception;

class WarnaNotFoundException extends Exception {
    
    public function report() {}

    public function render($request) {
        return response()->json([
            'status' => 404,
            'message' => 'Warna tidak dapat ditemukan!',
            'data' => null
        ], 404);
    }

}
