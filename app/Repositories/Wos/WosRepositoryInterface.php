<?php

namespace App\Repositories\Wos;

interface WosRepositoryInterface {

    /**
     * method untuk mendapatkan semua `wos`
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan `wos`
     * @param int
     * @return object
     */
    public function get(int $id) : ?object;

    /**
     * method untuk mendapatkan semua `wos` dan relasinya
     * @return object
     */
    public function allWithRelations() : object;

    /**
     * method untuk mendapatkan `wos` dan relasinya
     * @param int
     * @return object
     */
    public function oneWithRelations(int $id) : object;

    /**
     * method untuk membuat `wos`
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengupdate `wos`
     * @param int
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object;

    /**
     * method untuk menghapus `wos`
     * @param int
     * @return object
     */
    public function remove(int $id) : object;

    /**
     * method untuk mendapatkan `wos` yang sudah completed dan belum dibayar
     * @return object
     */
    public function wosPayment() : object;

    /**
     * method untuk membayar `wos`
     * @param array
     * @return object
     */
    public function pay(int $id, array $data) : object;

    /**
     * method untuk mendapatkan `wos` yang lagi di progress
     * @param string
     * @return object
     */
    public function onProgress(string $kodeBarang) : object;

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string;

    /**
     * method untuk mendapatkan jumlah wos
     * @return object
     */
    public function countRecords() : string;

    /**
     * method untuk mendapatkan data dengan kode_barang tertentu ada atau tidak
     * @param string
     * @return bool
     */
    public function isKodeBarangLinked(string $kode) : bool;

    /**
     * method untuk mendapatkan semua `wos` untuk datatable
     * @param string
     * @param string
     * @return object
     */
    public function allDatatable(string $start, string $length) : object;

    /**
     * method untuk mendapatkan mendapatkan detail `wos` berdasarkan id
     * @param int
     * @return object
     */
    public function detail(int $id) : object;
}