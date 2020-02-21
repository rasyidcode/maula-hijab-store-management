<?php

namespace App\Repositories\JenisBahan;

interface JenisBahanRepositoryInterface {

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string;

    /**
     * method untuk mendapatkan semua jenis_bahan
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan jenis_bahan berdasarkan kode
     * @param string
     * @return object
     */
    public function get(string $kode) : ?object;

    /**
     * method untuk mendapatkan list nama_bahan
     * @return object
     */
    public function getListNamaBahan(?string $warna = null) : object;

    /**
     * method untuk mendapatkan list warna berdasarkan nama
     * @param string
     * @return object
     */
    public function getListWarnaBahan(?string $nama = null) : object;

    /**
     * method untuk mendapatkan jenis_bahan dan juga relasinya yaitu 'bahan'
     * @param kode
     * @return object
     */
    public function oneWithBahan(string $kode) : object;

    /**
     * method untuk mendapatkan semua jenis_bahan dan juga relasinya 'bahan'
     * @return object
     */
    public function allWithBahan() : object;

    /**
     * method untuk membuat jenis_bahan
     * @param object
     * @return object
     */
    public function create(array $jenisBahan) : object;

    /**
     * method untuk memperbaharui jenis_bahan
     * @param string
     * @param object
     * @return object
     */
    public function edit(string $kode, array $jenisBahan) : object;

    /**
     * method untuk menghapus jenis_bahan
     * @param int
     * @return object
     */
    public function remove(string $kode) : object;

    /**
     * method untuk mengecheck nama `jenis_bahan` ada atau tidak
     * @param string
     * @return bool
     */
    public function isNamaBahanExist(string $name) : bool;
}