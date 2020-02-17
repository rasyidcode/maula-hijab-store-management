<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

use App\Http\Controllers\Helper\GeneralHelper;
use App\Http\Controllers\Helper\CrudHelper;
use App\Http\Controllers\Helper\ValidatorConstantHelper;

use App\Models\Bahan;
use App\Models\Wos;

class WosController extends Controller {

    public function getAllWos() {
        $allWos = Wos::all();
        return GeneralHelper::send_response(200, "Berhasil!", $allWos);
    }

    public function getAllWosCompleted() {
        $allWosCompleted = Wos::with('barang')->with('bahan')->with('penjahit')->orderBy('created_at', 'ASC')->get();
        return GeneralHelper::send_response(200, "Berhasil", $allWosCompleted);
    }

    public function getWos($id) {
        $wos = Wos::find($id);
        return GeneralHelper::send_response(200, "Berhasil!", $wos);
    }

    public function createWos(Request $request) {
        $data = $request->only(['kode_barang', 'id_bahan', 'pcs']);

        $bahan = Bahan::find($data['id_bahan']);
        $data['yard'] = $bahan->yard;

        $bahan->status_potong = true;
        $bahan->save();

        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_WOS,
            ValidatorConstantHelper::MESSAGES_WOS
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422,
                "validator error",
                $validator->errors()
            );
        }
        $wos = Wos::create($data);
        return GeneralHelper::send_response(200, 'Wos berhasil ditambahkan!', $wos);
    }

    public function updateWos(Request $request, int $id) {
        $data = $request->only(['kode_barang', 'id_bahan', 'yard', 'pcs']);
        $validator = Validator::make(
            $data,
            ValidatorConstantHelper::RULES_WOS,
            ValidatorConstantHelper::MESSAGES_WOS
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422,
                "validator error",
                $validator->errors()
            );
        }
        $updatedWos = Wos::where('id', $id)->update($data);
        return GeneralHelper::send_response(200, "Wos berhasil diperbaharui!", $updatedWos);
    }

    public function takeWos(Request $request, $id)
    {
        $data = $request->only(['tanggal_ambil', 'no_ktp_penjahit']);
        $validator = Validator::make
        (
            $data,
            [
                'tanggal_ambil' => 'required', 
                'no_ktp_penjahit' => 'required'
            ],
            [
                'tanggal_ambil.required' => 'Tanggal ambil harus didefinisikan!', 
                'no_ktp_penjahit.required' => 'No. ktp penjahit harus didefinisikan!'
            ]
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422,
                "validator error",
                $validator->errors()
            );
        }
        $updatedWos = Wos::where('id', $id)->update($data);
        return GeneralHelper::send_response(200, 'Wos berhasil diambil!', $updatedWos);
    }

    public function setorWos(Request $request, int $id) {
        $data = $request->only(['tanggal_kembali', 'jumlah_kembali']);
        $wosSetor = Wos::find($id);
        if ($wosSetor->tanggal_ambil === null) {
            return GeneralHelper::send_response(
                422,
                'Barang belum diambil!!!',
                null
            );
        }
        $validateReturnedGoods = $data['jumlah_kembali'] + $wosSetor->jumlah_kembali;
        if ($validateReturnedGoods > $wosSetor->pcs) {
            return GeneralHelper::send_response(
                422,
                'Jumlah kembali tidak boleh melebih pcs!',
                null
            );
        }
        $validator = Validator::make(
            $data,
            [ 'tanggal_kembali' => 'required', 'jumlah_kembali' => 'required|numeric' ],
            [ 
                'tanggal_kembali.required' => 'Tanggal kembali tidak boleh kosong',
                'jumlah_kembali.required' => 'Jumlah kembali tidak boleh kosong',
                'jumlah_kembali.numeric' => 'Jumlah kembali harus berupa angka'
            ]
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422,
                "validator error",
                $validator->errors()
            );
        }
        $data['jumlah_kembali'] = $data['jumlah_kembali'] + $wosSetor->jumlah_kembali;
        if ($data['jumlah_kembali'] != $wosSetor->pcs) {
            $data['tanggal_kembali'] = null;
        }
        Wos::where('id', $id)->update($data);
        $updatedWos = Wos::find($id);
        return GeneralHelper::send_response(200, 'Wos berhasil dikembalikan!', $updatedWos);
    }

    public function takeMultiWos(Request $request) {
        $data = $request->only(['tanggal_ambil', 'no_ktp_penjahit']);
        $data2 = $request->only(['ids_wos']);
        $validatorData = Validator::make(
            $data,
            ['tanggal_ambil' => 'required', 
             'no_ktp_penjahit' => 'required'],
            ['tanggal_ambil.required' => 'Tanggal harus diisi!',
             'no_ktp_penjahit.required' => 'No. ktp penjahit harus diisi!']
        );
        if ($validatorData->fails()) {
            return GeneralHelper::send_response(
                422,
                "validator error",
                $validatorData->errors()
            );
        }
        $validatorIdsWos = Validator::make(
            $data2,
            ['ids_wos' => 'required|array'],
            ['ids_wos.required' => 'Ids wos tidak boleh kosong!', 'ids_wos.array' => 'Ids wos harus berupa array!']
        );
        if ($validatorIdsWos->fails()) {
            return GeneralHelper::send_response(
                422,
                "validator error",
                $validatorIdsWos->errors()
            );
        }
        foreach($data2['ids_wos'] as $id) {
            Wos::where('id', $id)->update($data);
        }
        $allUpdatedWos = Wos::find($data2['ids_wos']);
        return GeneralHelper::send_response(200, 'Wos berhasil diambil!', $allUpdatedWos);
    }

    public function setorMultiWos(Request $request) {
        $data = $request->only(['tanggal_kembali']);
        $data2 = $request->only(['wos_kembali']);
        $errorWosTanggalKembali = [];
        $errorWosMelewatiPcs = [];
        foreach($data2['wos_kembali'] as $kembali) {
            $wosKembali = Wos::find($kembali['id']);
            if ($wosKembali->tanggal_ambil === null) {
                array_push($errorWosTanggalKembali, "Tanggal ambil wos dengan id `{$kembali['id']}` masih kosong!!!");
            }
        }
        if (count($errorWosTanggalKembali) > 0) {
            return GeneralHelper::send_response(
                422,
                "Wos yang dipilih tidak boleh yang belum diambil!!!",
                $errorWosTanggalKembali
            );
        }
        foreach($data2['wos_kembali'] as $kembali) {
            $wosKembali = Wos::find($kembali['id']);
            $kembali['jumlah_kembali'] += $wosKembali->jumlah_kembali;
            if ($kembali['jumlah_kembali'] > $wosKembali->pcs) {
                array_push($errorWosMelewatiPcs, "Wos dengan id `{$kembali['id']}` tidak boleh melebihi pcs");
            }
        }
        if (count($errorWosMelewatiPcs) > 0) {
            return GeneralHelper::send_response(
                422,
                "Wos yang dipilih tidak boleh melebihi pcs!!!",
                $errorWosMelewatiPcs
            );
        }
        $validator = Validator::make(
            $data,
            [ 'tanggal_kembali' => 'required' ],
            [ 'tanggal_kembali.required' => 'Tanggal kembali tidak boleh kosong' ]
        );
        if ($validator->fails()) {
            return GeneralHelper::send_response(
                422,
                "validator error",
                $validator->errors()
            );
        }
        $validator2 = Validator::make(
            $data2,
            [ 'wos_kembali' => 'required|array' ],
            [ 'wos_kembali.required' => 'Wos kembali tidak boleh kosong!',
              'wos_kembali.array' => 'Wos kembali harus berupa array!' ]
        );
        $ids = array();
        foreach($data2['wos_kembali'] as $kembali) {
            array_push($ids, $kembali['id']);
            $prepareData['tanggal_kembali'] = $data['tanggal_kembali'];
            $prepareData['jumlah_kembali'] = $kembali['jumlah_kembali'];
            $wos = Wos::find($kembali['id'])->update($prepareData);
        }
        $updatedWos = Wos::find($ids);
        return GeneralHelper::send_response(200, 'Wos telah diperbaharui!', $updatedWos);
    }

    public function getOnProgress(string $kode_barang) {
        $dataWos = DB::table('wos')
            ->select(DB::raw('SUM(pcs) as total_pcs'), DB::raw('SUM(jumlah_kembali) as total_jumlah_kembali'))
            ->where('kode_barang', $kode_barang)
            ->get();
        return GeneralHelper::send_response(200, 'Berhasil', $dataWos[0]);
    }
}
