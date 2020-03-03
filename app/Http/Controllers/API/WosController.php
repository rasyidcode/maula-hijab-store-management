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
use App\Repositories\TransaksiKain\TransaksiKainRepositoryInterface as TransaksiKainRepo;
use App\Repositories\Barang\BarangRepositoryInterface as BarangRepo;
use App\Repositories\Penjahit\PenjahitRepositoryInterface as PenjahitRepo;

class WosController extends Controller {

    protected $trash;
    protected $wos;
    protected $transaksiKain;
    protected $barang;
    protected $penjahit;
    

    public function __construct(
        WosRepo $wosRepo, 
        TrashRepo $trashRepo, 
        TransaksiKainRepo $transaksiKainRepo, 
        BarangRepo $barangRepo,
        PenjahitRepo $penjahitRepo
    ) {
        $this->wos = $wosRepo;
        $this->trash = $trashRepo;
        $this->transaksiKain = $transaksiKainRepo;
        $this->barang = $barangRepo;
        $this->penjahit = $penjahitRepo;
    } 

    public function all() {
        $data = $this->wos->all();
        return Helper::send_response(200, "Berhasil!", $data);
    }

    public function get(int $id) {
        Helper::isWosExist($this->wos, $id);
        $data = $this->wos->get($id);
        return Helper::send_response(200, "Berhasil!", $data);
    }

    public function create(Request $request) {
        $userInput = $request->only(['kode_barang', 'id_transaksi_kain', 'pcs']);

        $validator = Validator::make($userInput, ValidatorHelper::rulesWos(), ValidatorHelper::messagesWos());
        if ($validator->fails()) return Helper::send_response(422, "validator error", $validator->errors());

        Helper::isBarangExist($this->barang, $userInput['kode_barang']);
        Helper::isTransaksikainExist($this->transaksiKain, $userInput['id_transaksi_kain']);

        $userInput['yard'] = $this->transaksiKain->getBahanYard($userInput['id_transaksi_kain']);
        $this->transaksiKain->setStatusPotong($userInput['id_transaksi_kain'], true);

        $data = $this->wos->create($userInput);
        return Helper::send_response(200, 'Wos berhasil ditambahkan!', $data);
    }

    public function edit(Request $request, int $id) {
        Helper::isWosExist($this->wos, $id);
        $userInput = $request->only(['kode_barang', 'id_transaksi_kain', 'pcs']);

        Helper::isBarangExist($this->barang, $userInput['kode_barang']);
        Helper::isTransaksikainExist($this->transaksiKain, $userInput['id_transaksi_kain']);

        $userInput['yard'] = $this->transaksiKain->getBahanYard($userInput['id_transaksi_kain']);
        
        $validator = Validator::make($userInput, ValidatorHelper::rulesWos(), ValidatorHelper::messagesWos());
        if ($validator->fails()) return Helper::send_response(422, "validator error", $validator->errors());

        $data = $this->wos->edit($id, $userInput);
        return Helper::send_response(200, "Wos berhasil diperbaharui!", $data);
    }

    public function take(Request $request, $id) {
        Helper::isWosExist($this->wos, $id);

        $userInput = $request->only(['tanggal_ambil', 'no_ktp_penjahit']);

        Helper::isPenjahitExist($this->penjahit, $userInput['no_ktp_penjahit']);

        $validator = Validator::make(
            $userInput, 
            ['tanggal_ambil' => 'required', 'no_ktp_penjahit' => 'required'],
            [ 'tanggal_ambil.required' => 'Tanggal ambil harus didefinisikan!', 'no_ktp_penjahit.required' => 'No. ktp penjahit harus didefinisikan!' ]
        );
        if ($validator->fails()) return Helper::send_response(422, "validator error", $validator->errors());

        $data = $this->wos->edit($id, $userInput);
        return Helper::send_response(200, 'Wos berhasil diambil!', $data);
    }

    public function return(Request $request, int $id) {
        Helper::isWosExist($this->wos, $id);
        $userInput = $request->only(['tanggal_kembali', 'jumlah_kembali']);

        $wos = $this->wos->get($id);
        $barang = $this->barang->get($wos->kode_barang);
        $totalStokReady = $barang->stok_ready + $userInput['jumlah_kembali'];
        
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

        $this->barang->addStok($wos->kode_barang, $totalStokReady);
        
        $data = $this->wos->edit($id, $userInput);
        return Helper::send_response(200, 'Wos berhasil dikembalikan!', $data);
    }

    public function takeMulti(Request $request) {
        $userInput = $request->only(['tanggal_ambil', 'no_ktp_penjahit']);
        $userInput2 = $request->only(['ids_wos']);

        foreach($userInput2 as $id) {
            Helper::isWosExist($this->wos, $id);
        }

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
            $updatedWos = $this->wos->edit($id, $userInput);
            array_push($data, $updatedWos);
        }

        return Helper::send_response(200, 'Wos berhasil diambil!', $data);
    }

    public function setorMulti(Request $request) {
        $userInput = $request->only(['tanggal_kembali']);
        $userInput2 = $request->only(['wos_kembali']);

        foreach($userInput2 as $idKembali) {
            Helper::isWosExist($this->wos, $id);
        }

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
            $wos = $this->wos->edit($kembali['id'], $prepareData);
            array_push($data, $wos);
        }

        return Helper::send_response(200, 'Wos telah diperbaharui!', $data);
    }

    public function remove(int $id) {
        /* check terlebih dahulu, jangan dihapus apabila ada yang pakai */
        Helper::isWosExist($this->wos, $id);
        $deletedData = $this->wos->remove($id);

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

        return Helper::send_response(200, "Wos berhasil dihapus", []);
    }

    public function onProgress(string $kodeBarang) {
        $data = $this->wos->onProgress($kodeBarang);
        return Helper::send_response(200, 'Berhasil', $data[0]);
    }

    public function allWithRelations() {
        $data = $this->wos->allWithRelations();
        return Helper::send_response(200, "Berhasil", $data);
    }

    public function oneWithRelations(int $id) {
        Helper::isWosExist($this->wos, $id);
        $data = $this->wos->oneWithRelations($id);
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function wosPayment() {
        $data = $this->wos->wosPayment();
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function pay(Request $request, int $id) {
        Helper::isWosExist($this->wos, $id);

        // $userInput = $request->only(['tanggal_bayar']);

        // $validator = Validator::make($userInput, ['tanggal_bayar' => 'required'], ['tanggal_bayar.required' => 'Tanggal bayar tidak boleh kosong!']);
        // if ($validator->fails()) return Helper::send_response(422, 'Validasi error!', $validator->errors());
        $userInput['tanggal_bayar'] = \Carbon\Carbon::now();
        $userInput['status_bayar'] = true;
        $data = $this->wos->pay($id, $userInput);
        return Helper::send_response(200, 'Jahitan berhasil dibayar!', $data);
    }

    public function allDatatable(Request $request) {
        $search = $request->search;
        $columns = $request->columns;
        $start = $request->start;
        $length = $request->length;

        $allData = $this->wos->allDatatable($start, $length);
        $totalRecords = $this->wos->countRecords();
        $totalFilteredRecords = $totalRecords;

        if ($request->has('search') && $search['value'] != '') {
            $searchVal = $search['value'];

            $filteredData = $this->wos->filterAll($columns, $searchVal, $start, $length);
            return Helper::send_datatable_response($request, $totalRecords, count($filteredData), $filteredData);
        }

        return Helper::send_datatable_response($request, $totalRecords, $totalFilteredRecords, $allData);
    }

    public function detail(int $id) {
        Helper::isWosExist($this->wos, $id);

        $data = $this->wos->detail($id);

        return Helper::send_response(200, "Berhasil", $data);
    }
}
