<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;
use App\Repositories\Bahan\BahanRepositoryInterface as BahanRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;

class BahanController extends Controller {

    protected $bahan;
    protected $trash;

    public function __construct(BahanRepo $bahanRepo, TrashRepo $trashRepo) {
        $this->bahan = $bahanRepo;
        $this->trash = $trashRepo;
    }
    
    public function index() {
        return Helper::send_response(200, 'Berhasil', $this->bahan->all());
    }

    public function get(int $id) {
        Helper::isBahanExist($this->bahan, $id);
        return Helper::send_response(200, 'Berhasil', $this->bahan->get($id));
    }

    public function create(Request $request) {
        $userInput = $request->only(['nama', 'deskripsi']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBahan(), ValidatorHelper::messageBahan());
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->bahan->create($userInput);
        return Helper::send_response(201, 'Bahan berhasil ditambahkan!', $data);
    }

    public function edit(Request $request, int $id) {
        Helper::isBahanExist($this->bahan, $id);
        $userInput = $request->only(['nama', 'deskripsi']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesBahan(false), ValidatorHelper::messageBahan(false));
        if ($validator->fails()) return Helper::send_response(422, "validation error", $validator->errors());

        $data = $this->bahan->edit($id, $userInput);
        return Helper::send_response(200, 'Bahan berhasil diedit!', $data);
    }

    public function remove(int $id) {
        Helper::isBahanExist($this->bahan, $id);

        $data = $this->bahan->remove($id);
        
        $newTrash = [
            'content' => (string) $data,
            'model' => $this->bahan->modelName(),
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
        return Helper::send_response(200, 'Bahan berhasil dihapus!', null);
    }

    public function paginate(Request $request) {
        $start = $request->input('start');
        $length = $request->input('length');

        return response()->json([
            "total_records" => count($this->bahan->all()),
            "status" => 200,
            "message" => 'Berhasil',
            "data" => $this->bahan->paginate($start, $length)
        ], 200);
    }
}
