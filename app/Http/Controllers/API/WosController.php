<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\ValidatorHelper;

use App\Repositories\Trash\TrashRepositoryInterface as TrashRepo;
use App\Repositories\Wos\WosRepositoryInterface as WosRepo;
use App\Repositories\Bahan\BahanRepositoryInterface as BahanRepo;

class WosController extends Controller {

    protected $trash;
    protected $wos;
    protected $bahan;
    

    public function __construct(WosRepo $wosRepo, TrashRepo $trashRepo, BahanRepo $bahanRepo) {
        $this->wos = $wosRepo;
        $this->trash = $trashRepo;
        $this->bahan = $bahanRepo;
    } 

    public function all() {
        $data = $this->wos->all();
        return Helper::send_response(200, "Berhasil!", $data);
    }

    public function allWithRelations() {
        $data = $this->wos->allWithRelations();
        // $data = Wos::with('barang')->with('bahan')->with('penjahit')->orderBy('created_at', 'ASC')->get();
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function get(int $id) {
        $data = $this->wos->get($id);
        return Helper::send_response(200, "Berhasil!", $data);
    }

    public function create(Request $request) {
        $userInput = $request->only(['kode_barang', 'id_bahan', 'pcs']);

        // $bahan = Bahan::find($userInput['id_bahan']);
        // $data['yard'] = $bahan->yard;
        $userInput['yard'] = $this->bahan->getYard($userInput['id_bahan']); // need to make!!
        $this->bahan->setStatusPotong(true); // need to make!!
        // $bahan->status_potong = true;
        // $bahan->save();

        $validator = Validator::make($userInput, ValidatorHelper::rulesWos(), ValidatorHelper::messagesWos());
        if ($validator->fails()) return Helper::send_response(422, "validator error", $validator->errors());

        $data = $this->wos->create($userInput);
        return Helper::send_response(200, 'Wos berhasil ditambahkan!', $data);
    }

    public function update(Request $request, int $id) {
        $userInput = $request->only(['kode_barang', 'id_bahan', 'yard', 'pcs']);
        
        $validator = Validator::make($userInput, ValidatorHelper::rulesWos(), ValidatorHelper::messagesWos());
        if ($validator->fails()) return Helper::send_response(422, "validator error", $validator->errors());

        $data = $this->wos->update($id, $userInput);
        return Helper::send_response(200, "Wos berhasil diperbaharui!", $data);
    }

    public function take(Request $request, $id) {
        $userInput = $request->only(['tanggal_ambil', 'no_ktp_penjahit']);
        $validator = Validator::make(
            $userInput, 
            ['tanggal_ambil' => 'required', 'no_ktp_penjahit' => 'required'],
            [ 'tanggal_ambil.required' => 'Tanggal ambil harus didefinisikan!', 'no_ktp_penjahit.required' => 'No. ktp penjahit harus didefinisikan!' ]
        );

        if ($validator->fails()) return Helper::send_response(422, "validator error", $validator->errors());

        $data = $this->wos->update($id, $userInput);
        return Helper::send_response(200, 'Wos berhasil diambil!', $data);
    }

    public function return(Request $request, int $id) {
        $userInput = $request->only(['tanggal_kembali', 'jumlah_kembali']);

        $wos = $this->wos->get($id);
        if ($wos->tanggal_ambil === null) return Helper::send_response(422, 'Barang belum diambil!!!', null);

        $validateReturnedGoods = $userInput['jumlah_kembali'] + $wos->jumlah_kembali;
        if ($validateReturnedGoods > $wos->pcs) return Helper::send_response(422, 'Jumlah kembali tidak boleh melebih pcs!', null);

        $validator = Validator::make($userInput,
            [ 'tanggal_kembali' => 'required', 'jumlah_kembali' => 'required|numeric' ],
            [ 'tanggal_kembali.required' => 'Tanggal kembali tidak boleh kosong',
              'jumlah_kembali.required' => 'Jumlah kembali tidak boleh kosong',
              'jumlah_kembali.numeric' => 'Jumlah kembali harus berupa angka'
            ]
        );
        if ($validator->fails()) return Helper::send_response(422, "validator error", $validator->errors());

        $userInput['jumlah_kembali'] = $userInput['jumlah_kembali'] + $wos->jumlah_kembali;
        if ($userInput['jumlah_kembali'] != $wos->pcs) 
            $userInput['tanggal_kembali'] = null;
        else
            $userInput['status_jahit'] = true;
        
        $data = $this->wos->update($id, $userInput);
        return Helper::send_response(200, 'Wos berhasil dikembalikan!', $data);
    }

    public function takeMulti(Request $request) {
        $userInput = $request->only(['tanggal_ambil', 'no_ktp_penjahit']);
        $userInput2 = $request->only(['ids_wos']);

        $validatorUserInput = Validator::make($userInput,
            ['tanggal_ambil' => 'required', 'no_ktp_penjahit' => 'required'],
            ['tanggal_ambil.required' => 'Tanggal harus diisi!', 'no_ktp_penjahit.required' => 'No. ktp penjahit harus diisi!']
        );
        if ($validatorUserInput->fails()) return Helper::send_response(422, "validator error", $validatorUserInput->errors());

        $validatorUserInput2 = Validator::make(
            $userInput2,
            ['ids_wos' => 'required|array'],
            ['ids_wos.required' => 'Ids wos tidak boleh kosong!', 'ids_wos.array' => 'Ids wos harus berupa array!']
        );
        if ($validatorUserInput2->fails()) return Helper::send_response(422, "validator error", $validatorUserInput2->errors());

        $data = [];
        foreach($userInput2['ids_wos'] as $id) {
            $updatedWos = $this->wos->update($id, $userInput);
            array_push($data, $updatedWos);
        }

        return Helper::send_response(200, 'Wos berhasil diambil!', $data);
    }

    public function setorMulti(Request $request) {
        $userInput = $request->only(['tanggal_kembali']);
        $userInput2 = $request->only(['wos_kembali']);

        $errorWosTanggalKembali = [];
        $errorWosMelewatiPcs = [];

        foreach($userInput2['wos_kembali'] as $kembali) {
            $wosKembali = $this->wos->get($kembali['id']);
            if ($wosKembali->tanggal_ambil === null) 
                array_push($errorWosTanggalKembali, "Tanggal ambil wos dengan id `{$kembali['id']}` masih kosong!!!");
        }
        if (count($errorWosTanggalKembali) > 0)
            return Helper::send_response(422, "Wos yang dipilih tidak boleh yang belum diambil!!!", $errorWosTanggalKembali);

        foreach($userInput2['wos_kembali'] as $kembali) {
            $wosKembali = $this->wos->get($kembali['id']);
            $kembali['jumlah_kembali'] += $wosKembali->jumlah_kembali;
            if ($kembali['jumlah_kembali'] > $wosKembali->pcs)
                array_push($errorWosMelewatiPcs, "Wos dengan id `{$kembali['id']}` tidak boleh melebihi pcs");
        }
        if (count($errorWosMelewatiPcs) > 0)
            return Helper::send_response(422, "Wos yang dipilih tidak boleh melebihi pcs!!!", $errorWosMelewatiPcs);

        $validator = Validator::make(
            $userInput,
            [ 'tanggal_kembali' => 'required' ],
            [ 'tanggal_kembali.required' => 'Tanggal kembali tidak boleh kosong' ]
        );
        if ($validator->fails())
            return Helper::send_response(422, "validator error", $validator->errors());

        $validator2 = Validator::make(
            $userInput2,
            [ 'wos_kembali' => 'required|array' ],
            [ 'wos_kembali.required' => 'Wos kembali tidak boleh kosong!',
              'wos_kembali.array' => 'Wos kembali harus berupa array!' ]
        );

        $data = [];
        foreach($userInput2['wos_kembali'] as $kembali) {
            array_push($ids, $kembali['id']);
            $prepareData['tanggal_kembali'] = $data['tanggal_kembali'];
            $prepareData['jumlah_kembali'] = $kembali['jumlah_kembali'];
            $wos = $this->wos->update($kembali['id'], $prepareData);
            array_push($data, $wos);
        }

        return Helper::send_response(200, 'Wos telah diperbaharui!', $data);
    }

    public function delete(int $id) {
        /* check terlebih dahulu, jangan dihapus apabila ada yang pakai */
       $deletedData = $this->wos->delete($id);

       $newTrash = [
            'content' => (string) $deletedData,
            'model' => $this->wos->getModelName(),
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

    public function onProgress(string $kodeBarang) {
        $data = $this->wos->onProgress($kodeBarang);
        return Helper::send_response(200, 'Berhasil', $data[0]);
    }

    public function getNotYetPaid() {
        $data = $this->wos->wosToPay();
        return $data;
    }

    public function pay(Request $request, int $id) {
        $payDate = $request->tanggal_bayar;

        $validator = Validator::make($userInput, ['tanggal_bayar' => 'required'], ['tanggal_bayar.required' => 'Tanggal bayar tidak boleh kosong!']);
        if ($validator->fails()) return Helper::send_response(422, 'Validasi error!', $validator->errors());

        $this->wos->pay($id, $payDate);
        return Helper::send_response(200, 'Jahitan berhasil dibayar!', null);
    }
}
