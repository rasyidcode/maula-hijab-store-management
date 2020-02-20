<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;

use App\Repositories\Barang\BarangRepositoryInterface as BarangRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;

class BarangController extends Controller {

    protected $barang;
    protected $trash;

    public function __construct(BarangRepo $barangRepo, TrashRepo $trashRepo) {
        $this->barang = $barangRepo;
        $this->trash = $trashRepo;
    }

    public function index() {
        $data = $this->barang->all();
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function allWithBahan() {
        $data = $this->barang->allWithBahan();
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function get(string $kode) {
        $data = $this->barang->get($kode);
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function oneWithBahan(string $kode) {
        $data = $this->barang->oneWithBahan($kode);
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function create(Request $request)  {
        $userInput = $request->only(["kode", "kode_induk", "warna", "stok_ready", "treshold"]);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBarang(true), ValidatorHelper::messagesBarang());
        if ($validator->fails()) return GeneralHelper::send_response(422, "validation error", $validator->errors());

        $data = $this->induk->create($userInput);
        return Helper::send_response(201, "Barang berhasil ditambahkan", $data);
    }

    public function update(Request $request, string $kode)  {
        $userInput = $request->only(["kode", "kode_induk", "warna", "stok_ready", "treshold"]);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBarang(false), ValidatorHelper::messagesBarang());
        if ($validator->fails()) return GeneralHelper::send_response(422, "validation error", $validator->errors());

        $data = $this->barang->update($kode, $userInput);

        return Helper::send_response(200, "Barang berhasil diperbaharui!", $data);
    }

    public function delete(string $kode) {
        $deletedData = $this->barang->delete($kode);

        $newTrash = [
            'content' => (string) $deletedData,
            'model' => $this->barang->getModelName(),
            'method' => __METHOD__,
            'class' => __CLASS__,
            'line_number' => (__LINE__ - 6),
            'namespace' => __NAMESPACE__,
            'file' => __FILE__,
            'dir' => __DIR__,
            'deleted_date' => Carbon::now()->format('Y-m-d'),
            'deleted_time' => Carbon::now()->format('H:i:s')
        ];
        $this->trash->create($newTrash);

        return Helper::send_response(200, "Barang berhasil dihapus", []);
    }

    public function countOnProgress() {
        $data = $this->barang->countOnProgress();
        return Helper::send_response(200, 'Berhasil', $data);
    }
}
