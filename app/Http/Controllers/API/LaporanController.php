<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Repositories\TransaksiKain\TransaksiKainRepositoryInterface as TransaksiKainRepo;
use App\Repositories\Barang\BarangRepositoryInterface as BarangRepo;

class LaporanController extends Controller {
    
    protected $transaksiKain;
    protected $barang;

    public function __construct(TransaksiKainRepo $transaksiKainRepo, BarangRepo $barangRepo) {
        $this->transaksiKain = $transaksiKainRepo;
        $this->barang = $barangRepo;
    }

    public function transaksi_kain() {
        $data = $this->transaksiKain->laporan();
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function barang() {
        $data = $this->barang->laporan();
        return Helper::send_response(200, 'Berhasil', $data);
    }
}
