<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;
use App\Repositories\Kain\KainRepositoryInterface as KainRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;

# TODO: get semua jenis bahan tapi hanya menampilkan kodenya saja
# TODO: get semua jenis bahan where nama = 'something' dan hanya tampilkan kodenya saja dan query nya akan dipassing di params
# TODO: get semua jenis bahan where warna = 'something' dan hanya tampilkan kodenya saja dan querynya akan dipassing di params
class KainController extends Controller {

    protected $kain;
    protected $trash;

    public function __construct(KainRepo $kainRepo, TrashRepo $trashRepo) {
        $this->kain = $kainRepo;
        $this->trash = $trashRepo;
    }

    public function index() {
        $data = $this->kain->all();
        return Helper::send_response(200, 'Berhasil!', $data);
    }

    public function get(string $kode) {
        Helper::isKainExist($this->kain, $kode);
        $data = $this->kain->get($kode);
        return Helper::send_response(200, 'Berhasil!', $data);
    }

    public function create(Request $request) {
        $userInput = $request->only(['kode', 'nama', 'warna']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesKain(true), ValidatorHelper::messagesKain());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->kain->create($userInput);
        return Helper::send_response(200, 'Kain berhasil ditambah!', $data);
    }

    public function edit(Request $request, string $kode) {
        $userInput = $request->only(['kode', 'nama', 'warna']);

        Helper::isKainExist($this->kain, $kode);

        $validator = Validator::make($userInput, ValidatorHelper::rulesKain(false), ValidatorHelper::messagesKain());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->kain->edit($kode, $userInput);
        return Helper::send_response(200, 'Kain berhasil diedit!', $data);
    }

    public function remove(string $kode) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        Helper::isKainExist($this->kain, $kode);
        
        $data = $this->kain->remove($kode);
        $newTrash = [
            'content' => (string) $data,
            'model' => $this->kain->getModelName(),
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
        return Helper::send_response(200, 'Kain berhasil dihapus!', []);
    }

    public function allWithRelations() {
        $all = $this->kain->allWithRelations();
        return Helper::send_response(200, 'Berhasil', $all);
    }

    public function oneWithRelations(string $kode) {
        Helper::isKainExist($this->kain, $kode);
        $one = $this->kain->oneWithRelations($kode);
        return Helper::send_response(200, 'Berhasil', $one);
    }

    public function listNamaKain(Request $request) {
        $warna = $request->input('warna');

        if ($warna != null) {
            if (!$this->kain->isWarnaKainExist($warna)) {
                return Helper::send_response(404, 'Warna kain tersebut tidak ditemukan!', null);
            }
            $data = $this->kain->listNamaKain($warna);
            return Helper::send_response(200, 'Berhasil', $data);
        } else {
            $data = $this->kain->listNamaKain();
            return Helper::send_response(200, 'Berhasil', $data);
        }
    }

    public function listWarnaKain(Request $request) {
        $nama = $request->input('nama');
        
        if ($nama != null) {
            if (!$this->kain->isNamaKainExist($nama)) {
                return Helper::send_response(404, 'Nama kain tersebut tidak ditemukan!', null);
            }
            $data = $this->kain->listWarnaKain($nama);
            return Helper::send_response(200, 'Berhasil', $data);
        } else {
            $data = $this->kain->listWarnaKain();
            return Helper::send_response(200, 'Berhasil', $data);
        }
    }
}
