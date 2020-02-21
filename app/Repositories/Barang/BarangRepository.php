<?php

namespace App\Repositories\Barang;

use DB;

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
    public function get(string $kode) : ?object {
        return Barang::getByKode($kode)->first();
    }

    /**
     * method untuk membuat barang
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        Barang::create($data);
        $createdBarang = $this->get($data['kode']);
        return $createdBarang;
    }

    /**
     * method untuk mengupdate barang
     * @param string
     * @param array
     * @return object
     */
    public function edit(string $kode, array $data) : object {
        Barang::edit($kode, $data);
        $updatedBarang = $this->get($data['kode']);
        return $updatedBarang;
    }

    /**
     * method untuk mendelete barang
     * @param string
     * @return object
     */
    public function remove(string $kode) : object {
        $deletedData = $this->get($kode);
        Barang::remove($kode);
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
     * @return object
     */
    public function allWithOnProgress() : object {
        $data = DB::table('barang')
            ->join('wos', 'barang.kode', '=', 'wos.kode_barang')
            ->select('barang.*', DB::raw('(SUM(pcs) - SUM(jumlah_kembali)) as stok_on_progress'))
            ->groupBy('barang.kode')
            ->get();
        
        return $data;
    }

    /**
     * method untuk mendapatkan satu `barang` dan juga on_progressnya
     * @param string
     * @return object
     */
    public function oneWithOnProgress(string $kode) : object {
        $data = DB::table('barang')
            ->join('wos', 'barang.kode', '=', 'wos.kode_barang')
            ->select('barang.*', DB::raw('(SUM(pcs) - SUM(jumlah_kembali)) as stok_on_progress'))
            ->groupBy('barang.kode')
            ->where('kode', '=', $kode)
            ->get();
        
        return $data;
    }

    /**
     * method untuk mendapatkan semua `barang` dan juga relasinya
     * @return object
     */
    public function allWithInduk() : object {
        $data = Barang::with('induk')->get();
        return $data;
    }

    /**
     * method untuk mendapatkan satu `barang` dan juga relasinya
     * @param string
     * @return object
     */
    public function oneWithInduk(string $kode) : object {
        $data = Barang::with('induk')
            ->where('kode', '=', $kode)
            ->first();
        return $data;
    }

}