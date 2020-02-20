<?php

namespace App\Exceptions;

use Exception;

class JenisBahanNotFoundException extends Exception {
    
    public function report() {}

    public function render($request) {
        return response()->json([
            'status' => 404,
            'message' => 'Jenis bahan tidak dapat ditemukan!',
            'data' => null
        ], 404);
    }

}
