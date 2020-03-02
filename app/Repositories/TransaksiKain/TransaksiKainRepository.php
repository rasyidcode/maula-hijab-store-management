<?php

namespace App\Repositories\TransaksiKain;

use DB;

use App\Models\TransaksiKain;

class TransaksiKainRepository implements TransaksiKainRepositoryInterface {

    /**
     * method untuk mendapatkan semua `kain`
     * @param string
     * @param string
     * @return object
     */
    public function all(string $start, string $length) : object {
        $start = intval($start);
        $length = intval($length);
        $data = TransaksiKain::orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        return $data;
    }
    /**
     * method untuk mendapatkan bahan
     * @param integer
     * @return object
     */
    public function get(int $id) : ?object {
        return TransaksiKain::find($id);
    }

    /**
     * method untuk mendapatkan id, yard berdasarkan nama dan warna bahan yang telah
     * di input oleh user
     * @param string
     * @param string
     * @return object
     */
    public function getYard(string $nama, string $warna) : object {
        $data = TransaksiKain::getYard($nama, $warna, 0);
        return $data;
    }

    /**
     * method untuk membuat `transaksi_kain`
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $bhn = TransaksiKain::create($data);
        $createdData = $this->get($bhn->id);
        return $createdData;
    }

    /**
     * method untuk mengupdate `transaksi_kain`
     * @param integer
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object {
        TransaksiKain::edit($id, $data);
        $updatedData = $this->get($id);
        return $updatedData;
    }

    /**
     * method untuk menghapus `transaksi_kain`
     * @param integer
     * @return object
     */
    public function remove(int $id) : object {
        $deletedData = $this->get($id);
        TransaksiKain::remove($id);
        return $deletedData;
    }

    /**
     * method untuk mengganti status_potong `transaksi_kain`
     * @param bool
     * @return object
     */
    public function setStatusPotong(int $id, bool $value) : object {
        TransaksiKain::setStatusPotong($id, $value);
        $updatedData = $this->get($id);
        return $updatedData;
    }
    
    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return TransaksiKain::class;
    }

    /**
     * method untuk mengecheck status_potong `transaksi_kain`
     * @param integer
     * @return object
     */
    public function checkStatusPotong(int $id) : object {
        $data = $this->get($id);
        $response = new \stdClass();
        $response->status_potong = $data->status_potong == 1 ? true : false;
        return $response;
    }

    /**
     * method untuk mendapatkan jumlah `transaksi_kain` yang belum dipotong
     * @return int
     */
    public function countTransaksiKainBelumDiPotong() : int {
        $data = TransaksiKain::transaksiKainReady()->get();
        $count = count($data);
        return $count;
        
    }

    /**
     * method untuk mendapatkan yard `transaksi_kain` berdasarkan id
     * @param int
     * @return int
     */
    public function getBahanYard(int $id) : int {
        $data = $this->get($id);
        return $data->yard;
    }

    /**
     * method untuk memfilter semua columns
     * @param array
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function filterAll(array $columns, string $searchVal, string $start, string $length) : object {
        $kain = TransaksiKain::query();
        $start = intval($start);
        $length = intval($length);

        foreach($columns as $column) {
            if ($column['searchable'] == 'true') {
                $kain->orWhere($column['data'], 'like', "%{$searchVal}%");
            }
            $kain->skip($start)->take($length);
        }

        $data = $kain->get();
        return $data;
    }

    /**
     * method untuk menghitung total records `kain`
     * @return int
     */
    public function countRecords() : int {
        return count(TransaksiKain::all());
    }

    /**
     * method untuk mendapatkan semua yard berdasarkan `kode_kain`
     * @param string
     * @return object
     */
    public function getYards(string $kodeKain) : object {
        $data = TransaksiKain::select('id', 'yard')
            ->where('kode_kain', $kodeKain)
            ->where('status_potong', false)
            ->get();
        
        return $data;
    }
}