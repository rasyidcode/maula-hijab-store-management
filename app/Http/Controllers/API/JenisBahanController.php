<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;
use App\Repositories\JenisBahan\JenisBahanRepositoryInterface;
use App\Repositories\LoggerCrud\LoggerCrudRepositoryInterface;

class JenisBahanController extends Controller {

    protected $jenisBahan;
    protected $loggerCrud;

    public function __construct(
        JenisBahanRepositoryInterface $jenisBahanRepositoryInterface,
        LoggerCrudRepositoryInterface $loggerCrudRepositoryInterface) {
            $this->jenisBahan = $jenisBahanRepositoryInterface;
            $this->loggerCrud = $loggerCrudRepositoryInterface;
    }

    public function index() {
        $data = $this->jenisBahan->all();
        return Helper::send_response(200, 'Berhasil', $data);
    }

    # TODO: get semua jenis bahan tapi hanya menampilkan kodenya saja
    # TODO: get semua jenis bahan where nama = 'something' dan hanya tampilkan kodenya saja dan query nya akan dipassing di params
    # TODO: get semua jenis bahan where warna = 'something' dan hanya tampilkan kodenya saja dan querynya akan dipassing di params

    public function get(string $kode) {
        $data = $this->jenisBahan->get($kode);
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function getListNamaBahan() {
        $data = $this->jenisBahan->getListNamaBahan();
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function getListWarnaBahan(Request $request) {
        $nama = $request->input('nama');
        $data = $this->jenisBahan->getListWarnaBahan($nama);
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function getOneWithBahan(string $kode) {
        $one = $this->jenisBahan->oneWithBahan($kode);
        return Helper::send_response(200, "Berhasil", $one);
    }

    public function getAllWithBahan() {
        $all = $this->jenisBahan->allWithBahan();
        return GeneralHelper::send_response(200, 'Berhasil', $all);
    }

    public function create(Request $request) {
        $userInput = $request->only(['kode', 'nama', 'warna']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBahan(true), ValidatorHelper::messagesBahan(true));
        if ($validator->fails()) return GeneralHelper::send_response(422, "validation error", $validator->errors());

        $data = $this->jenisBahan->create($userInput);
        return GeneralHelper::send_response(200, 'Jenis bahan berhasil ditambahkan!', $data);
    }

    public function update(Request $request, string $kode) {
        $userInput = $request->only(['kode', 'nama', 'warna']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBahan(false), ValidatorHelper::messagesBahan(false));
        if ($validator->fails()) return GeneralHelper::send_response(422, "validation error", $validator->errors());

        $data = $this->jenisBahan->update($kode, $userInput);
        return GeneralHelper::send_response(200, 'Jenis bahan berhasil diperbaharui!', $data);
    }

    public function delete(string $kode) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        $data = $this->jenisBahan->delete($kode);
        return GeneralHelper::send_response(200, 'Jenis bahan berhasil dihapus!', []);
    }
}
