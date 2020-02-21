<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;
use App\Repositories\Bahan\BahanRepositoryInterface as BahanRepo;
use App\Repositories\JenisBahan\JenisBahanRepositoryInterface as JenisBahanRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;

class BahanController extends Controller {
    
    protected $bahan;
    protected $jenisBahan;
    protected $trash;

    public function __construct(BahanRepo $bahanRepo, JenisBahanRepo $jenisBahanRepo, TrashRepo $trashRepo) {
        $this->bahan = $bahanRepo;
        $this->jenisBahan = $jenisBahanRepo;
        $this->trash = $trashRepo;
    }

    public function index() {
        $data = $this->bahan->all();
        return Helper::send_response(200, "Berhasil", $data);
    }

    // public function getAllBahan() {
    //     $statusPotong = Request::get('status_potong');
    //     die($statusPotong);
    //     $allNotCatBahan = Bahan::where('status_potong', 0)->get();
    //     return GeneralHelper::send_response(200, "Bahan yang belum dipotong.", $allNotCatBahan);
    // }

    public function get(int $id) {
        Helper::isBahanExist($this->bahan, $id);
        $data = $this->bahan->get($id);
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function getOnlyYard(Request $request) {
        $nama = $request->input('nama');
        $warna = $request->input('warna');

        if ($nama != null && $warna != null) {
            $data = $this->bahan->getYard($nama, $warna);
            return Helper::send_response(200, 'Berhasil', $data);
        } else {
            return Helper::send_response(422, 'Nama dan baha tidak boleh kosong', null);
        }
    }

    public function create(Request $request) {
        $userInput = $request->only(['kode_jenis_bahan', 'harga', 'yard', 'tanggal_masuk']);

        Helper::isJenisBahanExist($this->jenisBahan, $userInput['kode_jenis_bahan']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBahan(true), ValidatorHelper::messagesBahan());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $userInput['value'] = $userInput['harga'] * $userInput['yard'];
        $data = $this->bahan->create($userInput);
        return Helper::send_response(201, "Bahan berhasil ditambahkan", $data);
    }

    public function edit(Request $request, int $id) {
        $userInput = $request->only(['kode_jenis_bahan', 'harga', 'yard', 'tanggal_masuk']);

        Helper::isJenisBahanExist($this->jenisBahan, $userInput['kode_jenis_bahan']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBahan(false), ValidatorHelper::messagesBahan());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $userInput['value'] = $userInput['harga'] * $userInput['yard'];
        $data = $this->bahan->edit($id, $userInput);
        return Helper::send_response(200, "Bahan berhasil diperbaharui", $data);
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
        Helper::isBahanExist($this->bahan, $id);
        $data = $this->bahan->setStatusPotong($id, $userInput['status_potong']);
        return Helper::send_response(200, "Status bahan telah diubah!", $data);
    }

    public function remove(int $id) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        Helper::isBahanExist($this->bahan, $id);
        $deletedData = $this->bahan->remove($id);
        $newTrash = [
            'content' => (string) $deletedData,
            'model' => $this->bahan->getModelName(),
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
        return Helper::send_response(200, "Bahan berhasil dihapus", []);
    }

    public function checkStatusPotong(int $id) {
        Helper::isBahanExist($this->bahan, $id);
        $data = $this->bahan->checkStatusPotong($id);
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function checkBahanReady() {
        $size = $this->bahan->countBahanBelumDiPotong();
        $response = new \stdClass();
        $response->is_ready = $size > 0 ? true : false;
        return Helper::send_response(200, 'Berhasil', $response);
    }

}
