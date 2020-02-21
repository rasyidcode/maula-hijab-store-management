<?php

namespace App\Repositories\Kain;

interface KainRepositoryInterface {

    /**
     * method untuk mendapatkan semua `kain`
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan `kain` berdasarkan kode
     * @param string
     * @return object
     */
    public function get(string $kode) : ?object;

    /**
     * method untuk membuat `kain`
     * @param object
     * @return object
     */
    public function create(array $jenisBahan) : object;

    /**
     * method untuk memperbaharui `kain`
     * @param string
     * @param object
     * @return object
     */
    public function edit(string $kode, array $jenisBahan) : object;

    /**
     * method untuk menghapus `kain`
     * @param int
     * @return object
     */
    public function remove(string $kode) : object;

    /**
     * method untuk mengecheck nama `kain` ada atau tidak
     * @param string
     * @return bool
     */
    public function isNamaKainExist(string $name) : bool;

    /**
     * method untuk mengecheck warna `kain` ada atau tidak
     * @param string
     * @return bool
     */
    public function isWarnaKainExist(string $warna) : bool;

    /**
     * method untuk mendapatkan semua jenis_bahan dan juga relasinya
     * @return object
     */
    public function allWithRelations() : object;

    /**
     * method untuk mendapatkan jenis_bahan dan juga relasinya
     * @param kode
     * @return object
     */
    public function oneWithRelations(string $kode) : object;

    /**
     * method untuk mendapatkan list nama_kain
     * @return object
     */
    public function listNamaKain(?string $warna = null) : object;

    /**
     * method untuk mendapatkan list warna_kain
     * @param string
     * @return object
     */
    public function listWarnaKain(?string $nama = null) : object;

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string;
}