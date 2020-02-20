<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;
use App\Repositories\JenisBahan\JenisBahanRepositoryInterface as JenisBahanRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;

# TODO: get semua jenis bahan tapi hanya menampilkan kodenya saja
# TODO: get semua jenis bahan where nama = 'something' dan hanya tampilkan kodenya saja dan query nya akan dipassing di params
# TODO: get semua jenis bahan where warna = 'something' dan hanya tampilkan kodenya saja dan querynya akan dipassing di params
class JenisBahanController extends Controller {

    protected $jenisBahan;
    protected $trash;

    public function __construct(JenisBahanRepo $jenisBahanRepo, TrashRepo $trashRepo) {
        $this->jenisBahan = $jenisBahanRepo;
        $this->trash = $trashRepo;
    }

    public function index() {
        $data = $this->jenisBahan->all();
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function get(string $kode) {
        $this->isJenisBahanExist($kode);
        $data = $this->jenisBahan->get($kode);
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function getListNamaBahan(Request $request) {
        $warna = $request->input('warna');

        if ($warna != null) {
            $data = $this->jenisBahan->getListNamaBahan($warna);
            return Helper::send_response(200, 'Berhasil', $data);
        } else {
            $data = $this->jenisBahan->getListNamaBahan();
            return Helper::send_response(200, 'Berhasil', $data);
        }
    }

    public function getListWarnaBahan(Request $request) {
        $nama = $request->input('nama');
        
        if ($nama != null) {
            if (!$this->jenisBahan->isNamaBahanExist($nama)) {
                return Helper::send_response(404, 'Nama bahan tersebut tidak ditemukan!', null);
            }
            $data = $this->jenisBahan->getListWarnaBahan($nama);
            return Helper::send_response(200, 'Berhasil', $data);
        } else {
            $data = $this->jenisBahan->getListWarnaBahan();
            return Helper::send_response(200, 'Berhasil', $data);
        }
    }

    public function getOneWithBahan(string $kode) {
        $this->isJenisBahanExist($kode);
        $one = $this->jenisBahan->oneWithBahan($kode);
        return Helper::send_response(200, "Berhasil", $one);
    }

    public function getAllWithBahan() {
        $all = $this->jenisBahan->allWithBahan();
        return Helper::send_response(200, 'Berhasil', $all);
    }

    public function create(Request $request) {
        $userInput = $request->only(['kode', 'nama', 'warna']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesJenisBahan(true), ValidatorHelper::messagesJenisBahan());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->jenisBahan->create($userInput);
        return Helper::send_response(200, 'Jenis bahan berhasil ditambahkan!', $data);
    }

    public function edit(Request $request, string $kode) {
        $userInput = $request->only(['kode', 'nama', 'warna']);

        $this->isJenisBahanExist($kode);

        $validator = Validator::make($userInput, ValidatorHelper::rulesJenisBahan(false), ValidatorHelper::messagesJenisBahan());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->jenisBahan->edit($kode, $userInput);
        return Helper::send_response(200, 'Jenis bahan berhasil diperbaharui!', $data);
    }

    public function remove(string $kode) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        $this->isJenisBahanExist($kode);
        
        $data = $this->jenisBahan->remove($kode);
        $newTrash = [
            'content' => (string) $data,
            'model' => $this->jenisBahan->getModelName(),
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
        return Helper::send_response(200, 'Jenis bahan berhasil dihapus!', []);
    }

    private function isJenisBahanExist(string $kode) {
        $checkData = $this->jenisBahan->get($kode);
        if ($checkData == null) {
            throw new \App\Exceptions\JenisBahanNotFoundException;
        }
    }
}
