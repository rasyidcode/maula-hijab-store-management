<?php

namespace App\Repositories\JenisBahan;

use DB;

use App\Models\JenisBahan;
use App\Http\Controllers\Helper\GeneralHelper as Helper;

class JenisBahanRepository implements JenisBahanRepositoryInterface {

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getClassName() : string {
        return JenisBahan::class;
    }

    /**
     * method untuk mendapatkan semua jenis_bahan
     * @return object
     */
    public function all() : object {
        $data = JenisBahan::all();
        return $data;
    }

    /**
     * method untuk mendapatkan jenis_bahan berdasarkan kode
     * @param string
     * @return object
     */
    public function get(string $kode) : object {
        $data = JenisBahan::getByKode($kode)->first();
        return $data;
    }

    /**
     * methond untuk mendapatkan list nama_bahan
     * @return object
     */
    public function getListNamaBahan() : object {
        $data = DB::table('jenis_bahan')
            ->select('nama')
            ->groupBy('nama')
            ->get();
        return $data;
    }

    /**
     * methond untuk mendapatkan list warna berdasarkan nama
     * @param string
     * @return object
     */
    public function getListWarna(string $nama) : object {
        $data = DB::table('jenis_bahan')
            ->select('warna')
            ->groupBy('warna')
            ->where('nama', '=', "{$nama}")
            ->get();
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
        JenisBahan::create($jenis_bahan);
        $createJenisBahan = $this->get($data->kode);
        return $createJenisBahan;
    }

    /**
     * method untuk memperbaharui jenis_bahan
     * TODO: sebelum diperbaharui, harus di record terlebih dahulu
     * @param string
     * @param object
     * @return object
     */
    public function update(string $kode, array $jenisBahan) : object {
        JenisBahan::updateByKode($kode, $jenisBahan);
        $updatedJenisBahan = $this->get($jenisBahan->kode);
        return $updatedJenisBahan;
    }

    /**
     * method untuk menghapus jenis_bahan
     * TODO: sebelum dihapus, harus di record terlebih dahulu
     * @param int
     * @return object
     */
    public function delete(string $kode) : object {
        $deletedData = $this->get($kode)->first();
        JenisBahan::deleteByKode($kode);
        
        return $deletedData;
    }
}