<?php

namespace App\Repositories\Bahan;

use DB;

use App\Models\Bahan;

class BahanRepository implements BahanRepositoryInterface {

    /**
     * method untuk mendapatkan semua bahan
     * @return object
     */
    public function all() : object {
        return Bahan::all();
    }

    /**
     * method untuk mendapatkan bahan
     * @param integer
     * @return object
     */
    public function get(int $id) : ?object {
        return Bahan::find($id);
    }

    /**
     * method untuk mendapatkan id, yard berdasarkan nama dan warna bahan yang telah
     * di input oleh user
     * @param string
     * @param string
     * @return object
     */
    public function getYard(string $nama, string $warna) : object {
        $data = Bahan::getYard($nama, $warna, 0);
        return $data;
    }

    /**
     * method untuk membuat bahan
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $bhn = Bahan::create($data);
        $createdData = $this->get($bhn->id);
        return $createdData;
    }

    /**
     * method untuk mengupdate bahan
     * @param integer
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object {
        Bahan::edit($id, $data);
        $updatedData = $this->get($id);
        return $updatedData;
    }

    /**
     * method untuk menghapus bahan
     * @param integer
     * @return object
     */
    public function remove(int $id) : object {
        $deletedData = $this->get($id);
        Bahan::remove($id);
        return $deletedData;
    }

    /**
     * method untuk mengganti status_potong `bahan`
     * @param bool
     * @return object
     */
    public function setStatusPotong(int $id, bool $value) : object {
        Bahan::setStatusPotong($id, $value);
        $updatedData = $this->get($id);
        return $updatedData;
    }
    
    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return Bahan::class;
    }

    /**
     * method untuk mengecheck status_potong `bahan`
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
     * method untuk mendapatkan jumlah bahan yang belum dipotong `bahan`
     * @return int
     */
    public function countBahanBelumDiPotong() : int {
        $data = Bahan::getBahanReady()->get();
        $count = count($data);
        return $count;
        
    }

    /**
     * method untuk mendapatkan yard `bahan` berdasarkan id
     * @param int
     * @return int
     */
    public function getBahanYard(int $id) : int {
        $data = $this->get($id);
        return $data->yard;
    }
}