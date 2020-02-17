<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Helper\GeneralHelper;
use App\Http\Controllers\Helper\CrudHelper;
use App\Http\Controllers\Helper\ValidatorConstantHelper;

use App\Models\Barang;

class BarangController extends Controller {

    public function get_all_barang() {
        $all_barang = CrudHelper::get_all(Barang::class);
        return GeneralHelper::send_response(200, "Berhasil", $all_barang);
    }

    public function get_all_barang_detailed() {
        $all_detailed_barang = CrudHelper::get_all_with2(Barang::class, "induk", "bahan");
        return GeneralHelper::send_response(200, "Berhasil", $all_detailed_barang);
    }

    public function get_barang(string $kode) {
        $barang = CrudHelper::getBy(Barang::class, "kode", $kode);
        return GeneralHelper::send_response(200, "Berhasil", $barang);
    }

    public function get_barang_detailed(string $kode) {
        $detailed_barang = CrudHelper::getBy2(Barang::class, "induk", "bahan", $kode);
        return GeneralHelper::send_response(200, "Berhasil", $detailed_barang);
    }

    public function create_barang(Request $request)  {
        $data = $request->only(["kode", "kode_induk", "warna", "stok_ready", "treshold"]);
        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_BARANG,
            ValidatorConstantHelper::MESSAGES_BARANG
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        }
        $barang = CrudHelper::create(Barang::class, $data);
        return GeneralHelper::send_response(201, "Barang berhasil ditambahkan", $barang);
    }

    public function update_barang(Request $request, string $kode)  {
        $data = $request->only(["kode", "kode_induk", "warna", "stok_ready", "treshold"]);
        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_BARANG2,
            ValidatorConstantHelper::MESSAGES_BARANG2
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        }
        $barang = CrudHelper::updateBy(Barang::class, "kode", $kode, $data);
        return GeneralHelper::send_response(200, "Barang berhasil diperbaharui!", $barang);
    }

    public function delete_barang(string $kode) {
        CrudHelper::deleteBy(Barang::class, "kode", $kode);
        return GeneralHelper::send_response(200, "Barang berhasil dihapus", []);
    }

    public function getAllBarangWithOnProgress() {
        $all_barang = DB::table('barang')
            ->join('wos', 'barang.kode', '=', 'wos.kode_barang')
            ->select('barang.*', DB::raw('(SUM(pcs) - SUM(jumlah_kembali)) as stok_on_progress'))
            ->groupBy('barang.kode')
            ->get();
        return GeneralHelper::send_response(200, 'Berhasil', $all_barang);
    }
}
