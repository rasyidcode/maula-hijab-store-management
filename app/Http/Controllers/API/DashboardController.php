<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Bahan;
use App\Http\Controllers\Helper\CrudHelper;

class DashboardController extends Controller {
    
    const RULES = [
        'nama_bahan' => 'required',
        'harga_bahan' => 'required|numeric'
    ];

    const MESSAGES = [
        'nama_bahan.required' => 'Nama barang tidak boleh kosong.',
        'harga_bahan.required' => 'Harga barang tidak boleh kosong',
        'harga_bahan.numeric' => 'Harga barang harus angka'
    ];

    public function get_all_bahan() {
        $all_bahan = CrudHelper::get_all(Bahan::class);

        return response()->json([
            "status" => 200,
            "message" => "Berhasil",
            'data' => $all_bahan
        ]);
    }

    public function get_bahan(int $id) {
        $bahan = CrudHelper::get(Bahan::class);

        return response()->json([
            "status" => 200,
            "message" => "Berhasil.",
            "data" => $bahan
        ]);
    }

    public function create_bahan(Request $request) {
        $data = $request->only(['nama_bahan', 'harga_bahan']);
        $validator = Validator::make($data, RULES, MESSAGES);

        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "message" => "validation error.",
                "errors" => $validator->errors()
            ]);
        }

        $bahan = CrudHelper::create(Bahan::class, $data);

        return response()->json([
            "status" => 201,
            "message" => "Bahan telah ditambahkan",
            "data" => $bahan
        ]);
    }

    public function update_bahan(Request $request, int $id) {
        $data = $request->only(['nama_bahan', 'harga_bahan']);
        $validator = Validator::make($data, RULES, MESSAGES);

        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "message" => "validation error.",
                "errors" => $validator->errors()
            ]);
        }

        $bahan = CrudHelper::update(Bahan::class, $id, $data);

        return response()->json([
            "status" => 200,
            "message" => "Bahan telah diupdate",
            "data" => $bahan
        ]);
    }

    public function delete_bahan(int $id) {
        // TODO : check kalo ada yang pakai id ini, jangan dihapus
        CrudHelper::delete(Bahan::class, $id);
        return response()->json([
            "status" => 200,
            "message" => "Bahan telah dihapus",
            "data" => []
        ]);
    }

}
