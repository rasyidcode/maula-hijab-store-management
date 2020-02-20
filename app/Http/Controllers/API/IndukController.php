<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;
use App\Repositories\Induk\IndukRepositoryInterface as IndukRepo;
use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;

class IndukController extends Controller {

    protected $induk;
    protected $trash;

    public function __construct(IndukRepo $indukRepo, TrashRepo $trashRepo) {
        $this->induk = $indukRepo;
        $this->trash = $trashRepo;
    }

    public function index() {
        $data = $this->induk->all();
        return Helper::send_response(200, "Berhasil!", $data);
    }

    // public function get_all_induk() {
    //     $all_induk = CrudHelper::get_all(Induk::class, ["kode", "nama_produk", "harga_jahit", "hpp", "created_at"]);
    //     return GeneralHelper::send_response(200, "Berhasil", $all_induk);
    // }

    public function get(string $kode) {
        $data = $this->induk->get($kode);
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function create(Request $request) {
        $userInput = $request->only(['kode', 'harga_jahit', 'harga_basic', 'hpp_shopee', 'hpp_lazada', 'dfs_shopee', 'dfs_lazada']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesInduk(true), ValidatorHelper::messagesInduk());
        if ($validator->fails()) return GeneralHelper::send_response(422, "validation error", $validator->errors());

        $data = $this->induk->create($userInput);
        return Helper::send_response(201, 'Induk berhasil ditambahkan!', $data);
    }

    public function update(Request $request, string $kode) {
        $userInput = $request->only(['kode', 'harga_jahit', 'harga_basic', 'hpp_shopee', 'hpp_lazada', 'dfs_shopee', 'dfs_lazada']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesInduk(false), ValidatorHelper::messagesInduk());
        if ($validator->fails()) return GeneralHelper::send_response(422, "validation error", $validator->errors());

        $data = $this->induk->update($kode, $userInput);
        return Helper::send_response(200, "Induk berhasil diperbaharui", $data);
    }

    public function delete(string $kode) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        $deletedData = $this->induk->delete($kode);

        $newTrash = [
            'content' => (string) $deletedData,
            'model' => $this->induk->getModelName(),
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

        return Helper::send_response(200, "Induk berhasil dihapus", []);
    }
}
