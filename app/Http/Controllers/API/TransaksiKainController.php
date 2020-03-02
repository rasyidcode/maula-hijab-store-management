<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;
use App\Repositories\TransaksiKain\TransaksiKainRepositoryInterface as TransaksiKainRepo;
use App\Repositories\Kain\KainRepositoryInterface as KainRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;

class TransaksiKainController extends Controller {
    
    protected $transaksiKain;
    protected $kain;
    protected $trash;

    public function __construct(TransaksiKainRepo $transaksiKainRepo, KainRepo $kainRepo, TrashRepo $trashRepo) {
        $this->transaksiKain = $transaksiKainRepo;
        $this->kain = $kainRepo;
        $this->trash = $trashRepo;
    }

    public function index(Request $request) {
        $search = $request->search;
        $columns = $request->columns;
        $start = $request->start;
        $length = $request->length;

        $allData = $this->transaksiKain->all($start, $length);
        $totalRecords = $this->transaksiKain->countRecords();
        $totalFilteredRecords = $totalRecords;

        if ($request->has('search') && $search['value'] != '') {
            $searchVal = $search['value'];

            $filteredData = $this->transaksiKain->filterAll($columns, $searchVal, $start, $length);
            return Helper::send_datatable_response($request, $totalRecords, count($filteredData), $filteredData);
        }
        return Helper::send_datatable_response($request, $totalRecords, $totalFilteredRecords, $allData);
    }

    // public function getAllBahan() {
    //     $statusPotong = Request::get('status_potong');
    //     die($statusPotong);
    //     $allNotCatBahan = Bahan::where('status_potong', 0)->get();
    //     return GeneralHelper::send_response(200, "Bahan yang belum dipotong.", $allNotCatBahan);
    // }

    public function get(int $id) {
        Helper::isTransaksiKainExist($this->transaksiKain, $id);
        $data = $this->transaksiKain->get($id);
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function getOnlyYard(Request $request) {
        $nama = $request->input('nama');
        $warna = $request->input('warna');

        if ($nama != null && $warna != null) {
            $data = $this->transaksiKain->getYard($nama, $warna);
            return Helper::send_response(200, 'Berhasil', $data);
        } else {
            return Helper::send_response(422, 'Nama dan warna tidak boleh kosong', null);
        }
    }

    public function create(Request $request) {
        $userInput = $request->only(['kode_kain', 'harga', 'yard', 'tanggal_masuk']);

        Helper::isKainExist($this->kain, $userInput['kode_kain']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesTransaksiKain(true), ValidatorHelper::messagesTransaksiKain());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $userInput['value'] = $userInput['harga'] * $userInput['yard'];
        $data = $this->transaksiKain->create($userInput);
        return Helper::send_response(201, "Transaksi kain berhasil ditambahkan", $data);
    }

    public function edit(Request $request, int $id) {
        $userInput = $request->only(['kode_kain', 'harga', 'yard', 'tanggal_masuk']);

        Helper::isKainExist($this->kain, $userInput['kode_kain']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesTransaksiKain(false), ValidatorHelper::messagesTransaksiKain());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $userInput['value'] = $userInput['harga'] * $userInput['yard'];
        $data = $this->transaksiKain->edit($id, $userInput);
        return Helper::send_response(200, "Transaksi kain berhasil diperbaharui", $data);
    }

    public function remove(int $id) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        Helper::isTransaksiKainExist($this->transaksiKain, $id);
        $deletedData = $this->transaksiKain->remove($id);
        $newTrash = [
            'content' => (string) $deletedData,
            'model' => $this->transaksiKain->getModelName(),
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
        return Helper::send_response(200, "Transaksi kain berhasil dihapus", []);
    }

    public function setStatusPotong(Request $request, int $id) {
        $userInput = $request->only(['status_potong']);
        $validator = Validator::make(
            $userInput, 
            ['status_potong' => 'required|boolean'], 
            ['status_potong.required' => 'Status potong tidak boleh kosong!',
             'status_potong.boolean' => 'Status potong harus berupa boolean!']);
        if ($validator->fails()) {
            return Helper::send_response(422, 'Validator error', $validator->errors());
        }
        Helper::isTransaksiKainExist($this->transaksiKain, $id);
        $data = $this->transaksiKain->setStatusPotong($id, $userInput['status_potong']);
        return Helper::send_response(200, "Status transaksi kain telah diubah!", $data);
    }

    public function checkStatusPotong(int $id) {
        Helper::isTransaksiKainExist($this->transaksiKain, $id);
        $data = $this->transaksiKain->checkStatusPotong($id);
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function checkTransaksiKainReady() {
        $size = $this->transaksiKain->countTransaksiKainBelumDiPotong();
        $response = new \stdClass();
        $response->is_ready = $size > 0 ? true : false;
        return Helper::send_response(200, 'Berhasil', $response);
    }

    public function detail(int $id) {
        $data = $this->transaksiKain->get($id);
        return Helper::send_response(200, 'Berhasil', $data);
    }

}
