<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function listJenisBahan() {
        return view('pages.inventory.jenis_bahan');
    }

    public function listBahan() {
        return view('pages.inventory.bahan');
    }

    public function induk() {
        return view('pages.inventory.induk');
    }

    public function barang() {
        return view('pages.inventory.barang');
    }

    public function penjahit() {
        return view('pages.produksi.penjahit');
    }

    public function wos() {
        return view('pages.produksi.wos');
    }

    public function pembayaran() {
        return view('pages.produksi.pembayaran');
    }

}
