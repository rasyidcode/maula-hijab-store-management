<?php

namespace App\Repositories\Barang;

use App\Models\Barang;

class BarangRepository implements BarangRepositoryInterface {
    
    /**
     * method untuk mendapatkan semua barang
     * @return object
     */
    public function all() : object {
        return Barang::all();
    }

    /**
     * method untuk mendapatkan barang
     * @param kode
     * @return object
     */
    public function get(string $kode) : object {
        return Barang::get($kode)->first();
    }

    /**
     * method untuk membuat barang
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $brg = Barang::create($data);
        $createdBarang = $this->get($brg->kode);
        return $createdBarang;
    }

    /**
     * method untuk mengupdate barang
     * @param string
     * @param array
     * @return object
     */
    public function update(string $kode, array $data) : object {
        Barang::update($data);
        $updatedBarang = $this->get($kode);
        return $updatedBarang;
    }

    /**
     * method untuk mendelete barang
     * @param string
     * @return object
     */
    public function delete(string $kode) : object {
        $deletedData = $this->get($kode);
        Barang::delete($kode);
        return $deletedData;
    }

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return Barang::class;
    }

    /**
     * method untuk menghitung jumlah stok yang on_progress
     * @return integer
     */
    public function countOnProgress() : integer {
        $data = DB::table('barang')
            ->join('wos', 'barang.kode', '=', 'wos.kode_barang')
            ->select('barang.*', DB::raw('(SUM(pcs) - SUM(jumlah_kembali)) as stok_on_progress'))
            ->groupBy('barang.kode')
            ->get();
        
        return $data;
    }

}