<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function listJenisBahan() {
        return view('pages.jenis_bahan');
    }

    public function listBahan() {
        return view('pages.bahan');
    }

}
