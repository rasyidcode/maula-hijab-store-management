<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;
use App\Repositories\Warna\WarnaRepositoryInterface as WarnaRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;


class WarnaController extends Controller {

    protected $warna;

    public function __construct(WarnaRepo $warnaRepo, TrashRepo $trashRepo) {
        $this->warna = $warnaRepo;
        $this->trash = $trashRepo;
    }
    
    public function index() {
        return Helper::send_response(200, 'Berhasil', $this->warna->all());
    }

    public function get(int $id) {
        Helper::isWarnaExist($this->warna, $id);
        return Helper::send_response(200, 'Berhasil', $this->warna->get($id));
    }

    public function create(Request $request) {
        $userInput = $request->only(['name', 'hex_code']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesWarna(), ValidatorHelper::messageWarna());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->warna->create($userInput);
        return Helper::send_response(200, 'Warna berhasil ditambahkan!', $data);
    }

    public function edit(Request $request, int $id) {
        Helper::isWarnaExist($this->warna, $id);
        $userInput = $request->only(['name', 'hex_code']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesWarna(false), ValidatorHelper::messageWarna(false));
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->warna->edit($id, $userInput);
        return Helper::send_response(200, 'Warna berhasil diedit!', $data);
    }

    public function remove(int $id) {
        Helper::isWarnaExist($this->warna, $id);
        $data = $this->warna->remove($id);
        
        $newTrash = [
            'content' => (string) $data,
            'model' => $this->warna->modelName(),
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

        return Helper::send_response(200, 'Warna berhasil dihapus!', []);
    }

    public function paginate(Request $request) {
        $start = $request->input('start');
        $length = $request->input('length');

        return response()->json([
            "total_records" => count($this->warna->all()),
            "status" => 200,
            "message" => 'Berhasil',
            "data" => $this->warna->paginate($start, $length)
        ], 200);
    }
}
