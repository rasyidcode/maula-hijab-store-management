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

class DashboardController extends Controller {

    /* start jenis_bahan */
    public function getAllJenisBahan() {
        $allJenisBahan = CrudHelper::get_all(JenisBahan::class);
        return GeneralHelper::send_response(200, "Berhasil", $allJenisBahan);
    }

    public function getJenisBahan(string $kode) {
        $jenisBahan = CrudHelper::getBy(JenisBahan::class, 'kode', $kode);
        return GeneralHelper::send_response(200, 'Berhasil', $jenisBahan);
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
    /* end jenis bahan */

    /* start bahan */
    public function get_all_bahan() {
        $all_bahan = CrudHelper::get_all(Bahan::class);
        return GeneralHelper::send_response(200, "Berhasil", $all_bahan);
    }

    public function get_bahan(int $id) {
        $bahan = CrudHelper::get(Bahan::class, $id);
        return GeneralHelper::send_response(200, "Berhasil", $bahan);
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

    public function delete_bahan(int $id) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        CrudHelper::delete(Bahan::class, $id);
        return GeneralHelper::send_response(200, "Bahan berhasil dihapus", []);
    }
    /* end bahan */

    /* start induk */
    public function get_all_induk() {
        $all_induk = CrudHelper::get_all(Induk::class, ["kode", "nama_produk", "harga_jahit", "hpp", "created_at"]);
        return GeneralHelper::send_response(200, "Berhasil", $all_induk);
    }

    public function get_induk(string $kode) {
        $induk = CrudHelper::getBy(Induk::class, 'kode', $kode);
        return GeneralHelper::send_response(200, "Berhasil", $induk);
    }

    public function create_induk(Request $request) {
        $data = $request->only(['kode', 'nama_produk', 'harga_jahit', 'hpp']);
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
        return GeneralHelper::send_response(201, "Induk berhasil ditambahkan", $induk);
    }

    public function update_induk(Request $request, string $kode) {
        $data = $request->only(['kode', 'nama_produk', 'harga_jahit', 'hpp']);
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

    /* start barang */
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
        $data = $request->only(["kode", "kode_induk", "warna", "stok", "treshold", "id_bahan"]);
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
        $data = $request->only(["kode", "kode_induk", "warna", "stok", "treshold", "id_bahan"]);
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
        $barang = CrudHelper::updateBy(Barang::class, "kode", $kode, $data);
        return GeneralHelper::send_response(200, "Barang berhasil diperbaharui", $barang);
    }

    public function delete_barang(string $kode) {
        CrudHelper::deleteBy(Barang::class, "kode", $kode);
        return GeneralHelper::send_response(200, "Barang berhasil dihapus", []);
    }
    /* end barang */

    /* start penjahit */
    public function getAllPenjahit() {
        $allPenjahit = CrudHelper::get_all(Penjahit::class);
        return GeneralHelper::send_response(200, "Berhasil!", $allPenjahit);
    }

    public function getAllPenjahitWithWos() {
        $allPenjahit = CrudHelper::get_all_penjahit_with_wos(Penjahit::class, 'wos');
        return GeneralHelper::send_response(200, 'Berhasil', $allPenjahit);
    }

    public function getPenjahit(string $nomor_hp) {
        $penjahit = CrudHelper::getBy(Penjahit::class, 'nomor_hp', $nomor_hp);
        return GeneralHelper::send_response(200, 'Berhasil!', $penjahit);
    }

    public function getAllWosByPenjahit(int $nomor_hp) {
        $penjahit = CrudHelper::get_wos_by_penjahit(Penjahit::class, 'wos', 'nomor_hp', $nomor_hp);
        return GeneralHelper::send_response(200, 'Berhasil', $penjahit);
    }

    public function createPenjahit(Request $request) {
        $data = $request->only(['nomor_hp', 'nama_lengkap', 'alamat']);

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
        return GeneralHelper::send_response(200, 'Penjahit telah ditambahkan', $penjahit);
    }

    public function updatePenjahit(Request $request, string $nomor_hp) {
        $data = $request->only(['nomor_hp', 'nama_lengkap', 'alamat']);

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

        $penjahit = CrudHelper::updateBy2(Penjahit::class, 'nomor_hp', $nomor_hp, $data);
        return GeneralHelper::send_response(200, 'Penjahit telah diperbaharui', $penjahit);
    }

    public function deletePenjahit(string $nomor_hp) {
        CrudHelper::deleteBy(Penjahit::class, "nomor_hp", $nomor_hp);
        return GeneralHelper::send_response(200, "Penjahit berhasil dihapus", []);
    }
    /* end panjahit */
}
