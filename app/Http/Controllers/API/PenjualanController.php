<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PenjualanController extends Controller {
    
    public function test(Request $request) {
        $file = $request->file('shopee_sample');

        // die($file->getClientOriginalExtension());

        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        return $sheetData;
    }
}
