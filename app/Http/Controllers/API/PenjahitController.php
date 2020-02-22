<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;

use App\Repositories\Penjahit\PenjahitRepositoryInterface as PenjahitRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;

class PenjahitController extends Controller {

    protected $penjahit;
    protected $trash;

    public function __construct(PenjahitRepo $penjahitRepo, TrashRepo $trashRepo) {
        $this->penjahit = $penjahitRepo;
        $this->trash = $trashRepo;
    }

    public function index() {
        $data = $this->penjahit->all();
        return Helper::send_response(200, "Berhasil!", $data);
    }

    public function allWithWos() {
        $data = $this->penjahit->allWithWos();
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function get(string $no_ktp) {
        Helper::isPenjahitExist($this->penjahit, $no_ktp);
        $data = $this->penjahit->get($no_ktp);
        return Helper::send_response(200, 'Berhasil!', $data);
    }

    public function oneWithWos(int $no_ktp) {
        Helper::isPenjahitExist($this->penjahit, $no_ktp);
        $data = $this->penjahit->oneWithWos($no_ktp);
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function create(Request $request) {
        $userInput = $request->only(['no_ktp', 'nama_lengkap', 'no_hp', 'alamat']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesPenjahit(true), ValidatorHelper::messagesPenjahit());

        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->penjahit->create($userInput);
        return Helper::send_response(200, 'Penjahit telah ditambahkan!', $data);
    }

    public function edit(Request $request, string $no_ktp) {
        $userInput = $request->only(['no_ktp', 'nama_lengkap', 'no_hp', 'alamat']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesPenjahit(false), ValidatorHelper::messagesPenjahit());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        Helper::isPenjahitExist($this->penjahit, $no_ktp);

        $data = $this->penjahit->edit($no_ktp, $userInput);
        return Helper::send_response(200, 'Penjahit telah diperbaharui!', $data);
    }

    public function remove(string $no_ktp) {
        /* check terlebih dahulu, jangan dihapus apabila ada yang pakai */
        Helper::isPenjahitExist($this->penjahit, $no_ktp);
        $deletedData = $this->penjahit->remove($no_ktp);

        $newTrash = [
            'content' => (string) $deletedData,
            'model' => $this->penjahit->getModelName(),
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

        return Helper::send_response(200, "Penjahit berhasil dihapus", []);
    }
}
