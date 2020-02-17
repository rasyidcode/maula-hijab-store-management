<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Helper\GeneralHelper;
use App\Http\Controllers\Helper\CrudHelper;
use App\Http\Controllers\Helper\ValidatorConstantHelper;

use App\Models\Bahan;

class BahanController extends Controller {
    
    public function get_all_bahan() {
        $all_bahan = CrudHelper::get_all(Bahan::class);
        return GeneralHelper::send_response(200, "Berhasil", $all_bahan);
    }

    public function getAllBahan() {
        $statusPotong = Request::get('status_potong');
        die($statusPotong);
        $allNotCatBahan = Bahan::where('status_potong', 0)->get();
        return GeneralHelper::send_response(200, "Bahan yang belum dipotong.", $allNotCatBahan);
    }

    public function get_bahan(int $id) {
        $bahan = CrudHelper::get(Bahan::class, $id);
        return GeneralHelper::send_response(200, "Berhasil", $bahan);
    }

    /**
     * TODO: bikin fungsi untuk mendapatkan list yard yang tersedia 
     * berdasarkan nama & warna jenis_bahan yang sudah dipilih sebelumnya 
     * dan belum dipotong 
     **/
    public function getOnlyYard(Request $request) {
        $nama = $request->input('nama');
        $warna = $request->input('warna');

        $yards = Bahan::select('id', 'yard')
            ->where('kode_jenis_bahan', 'like', "%{$nama}%")
            ->where('kode_jenis_bahan', 'like', "%{$warna}")
            ->where('status_potong', '=', false)
            ->get();

        return GeneralHelper::send_response(200, 'Berhasil', $yards);
    }

    public function create_bahan(Request $request) {
        $data = $request->only(['kode_jenis_bahan', 'harga', 'yard', 'tanggal_masuk']);
        $validator = Validator::make(
            $data, 
            ValidatorConstantHelper::RULES_BAHAN, 
            ValidatorConstantHelper::MESSAGES_BAHAN
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        }
        $data['value'] = $data['harga'] * $data['yard'];
        $bahan = CrudHelper::create(Bahan::class, $data);
        return GeneralHelper::send_response(201, "Bahan berhasil ditambahkan", $bahan);
    }

    public function update_bahan(Request $request, int $id) {
        $data = $request->only(['kode_jenis_bahan', 'harga', 'yard', 'tanggal_masuk']);
        $validator = Validator::make(
            $data, 
            ValidatorConstantHelper::RULES_BAHAN, 
            ValidatorConstantHelper::MESSAGES_BAHAN
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        }
        $data['value'] = $data['harga'] * $data['yard'];
        $bahan = CrudHelper::update(Bahan::class, $id, $data);
        return GeneralHelper::send_response(200, "Bahan berhasil diperbaharui", $bahan);
    }

    public function ganti_status_potong(Request $request, int $id) {
        $bahan = Bahan::find($id)->first();
        $bahan->status_potong = $request->status_potong;
        $bahan->save();

        return GeneralHelper::send_response(200, "Status bahan telah diubah!", $bahan);
    }

    public function delete_bahan(int $id) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        // TODO : data yang dihapus tidak benar2 dihapus, melainkan akan disimpan dalam
        //        satu tabel yang nantinya memuat informasi tentang data yang dihapus
        //        sehingga nantinya user mempunyai kontrol untuk mengundo data yang sudah dihapus
        CrudHelper::delete(Bahan::class, $id);
        return GeneralHelper::send_response(200, "Bahan berhasil dihapus", []);
    }

    public function checkStatusPotong(int $id) {
        $bahan = Bahan::find($id);
        $response = new \stdClass();
        $response->status_potong = $bahan->status_potong == 1 ? true : false;
        return GeneralHelper::send_response(200, 'Berhasil', $response);
    }

    /**
     * check bahan yang belum dipotong ada atau tidak
     */
    public function checkBahanReady() {
        $bahan = Bahan::where('status_potong', false)->get();
        $response = new \stdClass();
        $response->is_ready = count($bahan) > 0 ? true : false;
        return GeneralHelper::send_response(200, 'Berhasil', $response);
    }

}
