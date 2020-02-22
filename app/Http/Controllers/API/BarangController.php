<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;

use App\Repositories\Barang\BarangRepositoryInterface as BarangRepo;
use App\Repositories\Induk\IndukRepositoryInterface as IndukRepo;
use App\Repositories\Kain\KainRepositoryInterface as KainRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;

class BarangController extends Controller {

    protected $barang;
    protected $induk;
    protected $kain;
    protected $trash;

    public function __construct(BarangRepo $barangRepo, IndukRepo $indukRepo, KainRepo $kainRepo, TrashRepo $trashRepo) {
        $this->barang = $barangRepo;
        $this->induk = $indukRepo;
        $this->kain = $kainRepo;
        $this->trash = $trashRepo;
    }

    public function index() {
        $data = $this->barang->all();
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function get(string $kode) {
        Helper::isBarangExist($this->barang, $kode);
        $data = $this->barang->get($kode);
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function create(Request $request)  {
        $userInput = $request->only(["kode", "kode_induk", "kode_kain", "treshold"]);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBarang(true), ValidatorHelper::messagesBarang());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        Helper::isIndukExist($this->induk, $userInput['kode_induk']);
        Helper::isKainExist($this->kain, $userInput['kode_kain']);

        $data = $this->barang->create($userInput);
        return Helper::send_response(201, "Barang berhasil ditambahkan", $data);
    }

    public function edit(Request $request, string $kode)  {
        Helper::isBarangExist($this->barang, $kode);
        $userInput = $request->only(["kode", "kode_induk", "kode_kain", "treshold"]);
        Helper::isIndukExist($this->induk, $userInput['kode_induk']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBarang(false), ValidatorHelper::messagesBarang());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->barang->edit($kode, $userInput);

        return Helper::send_response(200, "Barang berhasil diperbaharui!", $data);
    }

    public function remove(string $kode) {
        Helper::isBarangExist($this->barang, $kode);
        $deletedData = $this->barang->remove($kode);

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

    public function allWithReadyAndProgress() {
        $data = $this->barang->allWithReadyAndProgress();
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function oneWithReadyAndProgress(string $kode) {
        Helper::isBarangExist($this->barang, $kode);
        $data = $this->barang->oneWithReadyAndProgress($kode);
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function allWithRelations() {
        $data = $this->barang->allWithRelations();
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function oneWithRelations(string $kode) {
        Helper::isBarangExist($this->barang, $kode);
        $data = $this->barang->oneWithRelations($kode);
        return Helper::send_response(200, "Berhasil", $data);
    }
}
