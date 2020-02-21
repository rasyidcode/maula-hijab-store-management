<?php

namespace App\Exceptions;

use Exception;

class BarangNotFoundException extends Exception {
    
    public function report() {}

    public function render($request) {
        return response()->json([
            'status' => 404,
            'message' => 'Barang tidak dapat ditemukan!',
            'data' => null
        ], 404);
    }

}
