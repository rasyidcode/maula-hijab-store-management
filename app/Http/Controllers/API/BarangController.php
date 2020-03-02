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
use App\Repositories\Wos\WosRepositoryInterface as WosRepo;
use App\Repositories\TransaksiKain\TransaksiKainRepository as TransaksiKainRepo;

class BarangController extends Controller {

    protected $barang;
    protected $induk;
    protected $wos;
    protected $kain;
    protected $trash;
    protected $transaksiKain;

    public function __construct(
        BarangRepo $barangRepo,
        IndukRepo $indukRepo,
        KainRepo $kainRepo,
        WosRepo $wosRepo,
        TrashRepo $trashRepo,
        TransaksiKainRepo $transaksiKainRepo) {
        $this->barang = $barangRepo;
        $this->induk = $indukRepo;
        $this->kain = $kainRepo;
        $this->wos = $wosRepo;
        $this->transaksiKain = $transaksiKainRepo;
        $this->trash = $trashRepo;
    }

    public function index(Request $request) {
        $data = $this->barang->all();
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function get(string $kode) {
        Helper::isBarangExist($this->barang, $kode);
        $data = $this->barang->get($kode);
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function create(Request $request)  {
        $userInput = $request->only(["kode", "kode_induk", "kode_kain", "stok_ready", "treshold"]);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBarang(true), ValidatorHelper::messagesBarang());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        Helper::isIndukExist($this->induk, $userInput['kode_induk']);
        Helper::isKainExist($this->kain, $userInput['kode_kain']);

        $data = $this->barang->create($userInput);
        return Helper::send_response(201, "Barang berhasil ditambahkan", $data);
    }

    public function edit(Request $request, string $kode)  {
        Helper::isBarangExist($this->barang, $kode);
        $userInput = $request->only(["kode", "kode_induk", "kode_kain", "stok_ready", "treshold"]);
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

    public function allWithOnProgress(Request $request) {
        $countWos = $this->wos->countRecords();
        $search = $request->search;
        $columns = $request->columns;
        $start = $request->start;
        $length = $request->length;

        if ($countWos > 0) {
            $allData = $this->barang->allWithOnProgress($start, $length);
            $totalRecords = $this->barang->countRecords();
            $totalFilteredRecords = $totalRecords;

            if ($request->has('search') && $search['value'] != '') {
                $searchVal = $search['value'];

                $filteredData = $this->barang->filterAll($columns, $searchVal, $start, $length);
                return Helper::send_datatable_response($request, $totalRecords, count($filteredData), $filteredData);
            }

            return Helper::send_datatable_response($request, $totalRecords, $totalFilteredRecords, $allData);
        } else {
            $allData = $this->barang->allNoWos();
            $totalRecords = $this->barang->countRecords();
            $totalFilteredRecords = $totalRecords;

            if ($request->has('search') && $search['value'] != '') {
                $searchVal = $search['value'];

                $filteredData = $this->barang->filterAllNoWos($columns, $searchVal, $start, $length);
                return Helper::send_datatable_response($request, $totalRecords, count($filteredData), $filteredData);
            }
            
            return Helper::send_datatable_response($request, $totalRecords, $totalFilteredRecords, $allData);
        }
    }

    public function oneWithOnProgress(string $kode) {
        Helper::isBarangExist($this->barang, $kode);
        $data = $this->barang->oneWithOnProgress($kode);
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

    public function detail(string $kode) {
        Helper::isBarangExist($this->barang, $kode);

        $data = $this->barang->detail($kode);
        return Helper::send_response(200, 'Berhasil', $data);   
    }

    public function getTransaksiKainYard(string $kodeBarang) {
        Helper::isBarangExist($this->barang, $kodeBarang);

        $kodeKain = $this->barang->get($kodeBarang)->kode_kain;
        $data = $this->transaksiKain->getYards($kodeKain);

        return Helper::send_response(200, 'Berhasil', $data);
    }
}
