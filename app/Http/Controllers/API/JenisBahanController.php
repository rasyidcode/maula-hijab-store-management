<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Helper\GeneralHelper;
use App\Http\Controllers\Helper\CrudHelper;
use App\Http\Controllers\Helper\ValidatorConstantHelper;

use App\Models\JenisBahan;

class JenisBahanController extends Controller {

    public function getAllJenisBahan() {
        $allJenisBahan = CrudHelper::get_all(JenisBahan::class);
        return GeneralHelper::send_response(200, "Berhasil", $allJenisBahan);
    }
    # TODO: get semua jenis bahan tapi hanya menampilkan kodenya saja
    # TODO: get semua jenis bahan where nama = 'something' dan hanya tampilkan kodenya saja dan query nya akan dipassing di params
    # TODO: get semua jenis bahan where warna = 'something' dan hanya tampilkan kodenya saja dan querynya akan dipassing di params

    public function getJenisBahan(string $kode) {
        $jenisBahan = CrudHelper::getBy(JenisBahan::class, 'kode', $kode);
        return GeneralHelper::send_response(200, 'Berhasil', $jenisBahan);
    }

    /* TODO: bikin fungsi untuk mendapatkan list nama jenis_bahan yang tersedia (no duplicate data) */
    public function getAvailNamaBahan() {
        $availNamaBahan = DB::table('jenis_bahan')
            ->select('nama')
            ->groupBy('nama')
            ->get();
        return GeneralHelper::send_response(200, 'Berhasil', $availNamaBahan);
    }
    /* TODO: bikin fungsi untuk mendapatkan list warna jenis_bahan yang tersedia (no duplicate data) */
    public function getAvailWarna(Request $request) {
        $nama = $request->input('nama');
        $availWarna = DB::table('jenis_bahan')
            ->select('warna')
            ->groupBy('warna')
            ->where('nama', '=', "{$nama}")
            ->get();
        return GeneralHelper::send_response(200, 'Berhasil', $availWarna);
    }

    public function createJenisBahan(Request $request) {
        $data = $request->only(['kode', 'nama', 'warna']);
        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_JENIS_BAHAN,
            ValidatorConstantHelper::MESSAGE_JENIS_BAHAN
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        }
        $jenisBahan = CrudHelper::create(JenisBahan::class, $data);
        return GeneralHelper::send_response(200, 'Jenis bahan berhasil ditambahkan!', $jenisBahan);
    }

    public function updateJenisBahan(Request $request, string $kode) {
        $data = $request->only(['kode', 'nama', 'warna']);
        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_JENIS_BAHAN2,
            ValidatorConstantHelper::MESSAGE_JENIS_BAHAN2
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        }
        $jenisBahan = CrudHelper::updateBy(JenisBahan::class, 'kode', $kode, $data);
        return GeneralHelper::send_response(200, 'Jenis bahan berhasil diperbaharui!', $jenisBahan);
    }

    public function deleteJenisBahan(string $kode) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        CrudHelper::deleteBy(JenisBahan::class, 'kode', $kode);
        return GeneralHelper::send_response(200, 'Jenis bahan berhasil dihapus!', []);
    }

    public function getJenisBahanCompleted(string $kode) {
        $jenisBahan = JenisBahan::with("bahan")->where('kode', $kode)->first();
        return GeneralHelper::send_response(200, "Berhasil", $jenisBahan);
    }
}
