<?php

namespace App\Exceptions;

use Exception;

class BahanNotFoundException extends Exception {
    
    public function report() {}

    public function render($request) {
        return response()->json([
            'status' => 404,
            'message' => 'Bahan tidak dapat ditemukan!',
            'data' => null
        ], 404);
    }

}
