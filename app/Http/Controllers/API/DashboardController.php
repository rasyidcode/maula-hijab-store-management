<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Controllers\Helper\GeneralHelper;
use App\Http\Controllers\Helper\CrudHelper;
use App\Http\Controllers\Helper\ValidatorConstantHelper;

use App\Models\JenisBahan;
use App\Models\Bahan;
use App\Models\Induk;
use App\Models\Barang;
use App\Models\Penjahit;
use App\Models\Wos;

// TODO: JANGAN ADA DATA YANG DIHAPUS, BUAT SATU TABEL UNTUK MERECORD SEMUA DATA
// TODO: Load data order by created_at, yang paling baru paling atas
class DashboardController extends Controller {
    /* start induk */
    public function getAllInduk() {
        $allInduk = CrudHelper::get_all(Induk::class);
        return GeneralHelper::send_response(200, "Berhasil!", $allInduk);
    }
    public function get_all_induk() {
        $all_induk = CrudHelper::get_all(Induk::class, ["kode", "nama_produk", "harga_jahit", "hpp", "created_at"]);
        return GeneralHelper::send_response(200, "Berhasil", $all_induk);
    }
    public function get_induk(string $kode) {
        $induk = CrudHelper::getBy(Induk::class, 'kode', $kode);
        return GeneralHelper::send_response(200, "Berhasil", $induk);
    }
    public function create_induk(Request $request) {
        $data = $request->only(['kode', 'harga_jahit', 'harga_basic', 'hpp_shopee', 'hpp_lazada', 'dfs_shopee', 'dfs_lazada']);
        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_INDUK, 
            ValidatorConstantHelper::MESSAGES_INDUK
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        } 
        $induk = CrudHelper::create(Induk::class, $data);
        return GeneralHelper::send_response(201, 'Induk berhasil ditambahkan!', $induk);
    }
    public function update_induk(Request $request, string $kode) {
        $data = $request->only(['kode', 'harga_jahit', 'harga_basic', 'hpp_shopee', 'hpp_lazada', 'dfs_shopee', 'dfs_lazada']);
        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_INDUK2, 
            ValidatorConstantHelper::MESSAGES_INDUK2
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        }
        $induk = CrudHelper::updateBy(Induk::class, 'kode', $kode, $data);
        return GeneralHelper::send_response(200, "Induk berhasil diperbaharui", $induk);
    }
    public function delete_induk(string $kode) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        CrudHelper::deleteBy(Induk::class, 'kode', $kode);
        return GeneralHelper::send_response(200, "Induk berhasil dihapus", []);
    }
    /* end induk */

    /* start penjahit */
    public function getAllPenjahit() {
        $allPenjahit = CrudHelper::get_all(Penjahit::class);
        return GeneralHelper::send_response(200, "Berhasil!", $allPenjahit);
    }

    public function getAllPenjahitWithWos() {
        $allPenjahit = CrudHelper::get_all_penjahit_with_wos(Penjahit::class, 'wos');
        return GeneralHelper::send_response(200, 'Berhasil', $allPenjahit);
    }

    public function getPenjahit(string $no_ktp) {
        $penjahit = CrudHelper::getBy(Penjahit::class, 'no_ktp', $no_ktp);
        return GeneralHelper::send_response(200, 'Berhasil!', $penjahit);
    }

    public function getAllWosByPenjahit(int $nomor_hp) {
        $penjahit = CrudHelper::get_wos_by_penjahit(Penjahit::class, 'wos', 'nomor_hp', $nomor_hp);
        return GeneralHelper::send_response(200, 'Berhasil', $penjahit);
    }

    public function createPenjahit(Request $request) {
        $data = $request->only(['no_ktp', 'nama_lengkap', 'no_hp', 'alamat']);

        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_PENJAHIT,
            ValidatorConstantHelper::MESSAGES_PENJAHIT
        );

        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        }

        $penjahit = CrudHelper::create(Penjahit::class, $data);
        return GeneralHelper::send_response(200, 'Penjahit telah ditambahkan!', $penjahit);
    }

    public function updatePenjahit(Request $request, string $no_ktp) {
        $data = $request->only(['no_ktp', 'nama_lengkap', 'no_hp', 'alamat']);

        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_PENJAHIT2,
            ValidatorConstantHelper::MESSAGES_PENJAHIT2
        );

        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422, 
                "validation error", 
                $validator->errors()
            );
        }

        $penjahit = CrudHelper::updateBy(Penjahit::class, 'no_ktp', $no_ktp, $data);
        return GeneralHelper::send_response(200, 'Penjahit telah diperbaharui!', $penjahit);
    }

    public function deletePenjahit(string $no_ktp) {
        /* check terlebih dahulu, jangan dihapus apabila ada yang pakai */
        CrudHelper::deleteBy(Penjahit::class, "no_ktp", $no_ktp);
        return GeneralHelper::send_response(200, "Penjahit berhasil dihapus", []);
    }
    /* end panjahit */
}
