<?php

namespace App\Repositories\JenisBahan;

use DB;

use App\Models\JenisBahan;

class JenisBahanRepository implements JenisBahanRepositoryInterface {

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return JenisBahan::class;
    }

    /**
     * method untuk mendapatkan semua jenis_bahan
     * @return object
     */
    public function all() : object {
        $data = JenisBahan::orderBy('created_at', 'desc')->get();
        return $data;
    }

    /**
     * method untuk mendapatkan jenis_bahan berdasarkan kode
     * @param string
     * @return object
     */
    public function get(string $kode) : ?object {  
        $data = JenisBahan::getOne($kode)->first();
        return $data;
    }

    /**
     * methond untuk mendapatkan list nama_bahan
     * @param string_or_null
     * @return object
     */
    public function getListNamaBahan(?string $warna = null) : object {
        if ($warna != null) {
            $data = DB::table('jenis_bahan')
                ->select('nama')
                ->groupBy('nama')
                ->where('warna', '=', "${warna}")
                ->get();
        } else {
            $data = DB::table('jenis_bahan')
                ->select('nama')
                ->groupBy('nama')
                ->get();
        }
        
        return $data;
    }

    /**
     * methond untuk mendapatkan list warna berdasarkan nama
     * @param string
     * @return object
     */
    public function getListWarnaBahan(?string $nama = null) : object {
        if ($nama != null) {
            $data = DB::table('jenis_bahan')
                ->select('warna')
                ->groupBy('warna')
                ->where('nama', '=', "{$nama}")
                ->get();
        } else {
            $data = DB::table('jenis_bahan')
                ->select('warna')
                ->groupBy('warna')
                ->get();
        }
        return $data;
    }

    /**
     * method untuk mendapatkan jenis_bahan dan juga relasinya yaitu 'bahan'
     * @param kode
     * @return object
     */
    public function oneWithBahan(string $kode) : object {
        $data = JenisBahan::getWithBahan($kode)->first();
        return $data;
    }

    /**
     * method untuk mendapatkan semua jenis_bahan dan juga relasinya 'bahan'
     * @return object
     */
    public function allWithBahan() : object {
        $data = JenisBahan::getAllWithBahan()->get();
        return $data;
    }

    /**
     * method untuk membuat jenis_bahan
     * @param object
     * @return object
     */
    public function create(array $data) : object {
        JenisBahan::create($data);
        $createdData = $this->get($data['kode']);
        return $createdData;
    }

    /**
     * method untuk memperbaharui jenis_bahan
     * TODO: sebelum diperbaharui, harus di record terlebih dahulu
     * @param string
     * @param object
     * @return object
     */
    public function edit(string $kode, array $data) : object {
        JenisBahan::edit($kode, $data);
        $updatedData = $this->get($data['kode']);
        return $updatedData;
    }

    /**
     * method untuk menghapus jenis_bahan
     * TODO: sebelum dihapus, harus di record terlebih dahulu
     * @param int
     * @return object
     */
    public function remove(string $kode) : object {
        $deletedData = $this->get($kode)->first();
        JenisBahan::remove($kode);
        
        return $deletedData;
    }

    /**
     * method untuk mengecheck nama `jenis_bahan` ada atau tidak
     * @param string
     * @return bool
     */
    public function isNamaBahanExist(string $name) : bool {
        $data = $this->getListNamaBahan();

        if (count($data) > 0) return true;
        else return false;
    }
}