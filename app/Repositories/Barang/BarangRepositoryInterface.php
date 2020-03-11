<?php

namespace App\Repositories\Barang;

interface BarangRepositoryInterface {

    /**
     * method untuk mendapatkan semua barang
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan barang
     * @param kode
     * @return object
     */
    public function get(string $kode) : ?object;

    /**
     * method untuk membuat barang
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengupdate barang
     * @param string
     * @param array
     * @return object
     */
    public function edit(string $kode, array $data) : object;

    /**
     * method untuk mendelete barang
     * @param string
     * @return object
     */
    public function remove(string $kode) : object;

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string;

    /**
     * method untuk mendapatkan semua `barang` dan juga yang lagi on_progress
     * @param string
     * @param string
     * @return object
     */
    public function allWithOnProgress(string $start, string $length) : object;

    /**
     * method untuk mendapatkan satu `barang` dan juga on_progressnya
     * @param string
     * @return object
     */
    public function oneWithOnProgress(string $kode) : object;

    /**
     * method untuk mendapatkan semua `barang` dan juga relasinya
     * @return object
     */
    public function allWithRelations() : object;

    /**
     * method untuk mendapatkan satu `barang` dan juga relasinya
     * @param string
     * @return object
     */
    public function oneWithRelations(string $kode) : object;

    /**
     * method untuk memfilter semua columns
     * @param array
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function filterAll(array $columns, string $searchVal, string $start, string $length) : object;

    /**
     * method untuk menghitung total records `barang`
     * @return int
     */
    public function countRecords() : int;

    /**
     * method untuk mendapatkan semua barang dengan empty_on_progress
     * @return object
     */
    public function allNoWos() : object;

    /**
     * method untuk mendapatkan semua field kode 
     */

    /**
     * method untuk mendapatkan detail `barang`
     * @param string
     * @return object
     */
    public function detail(string $kode) : object;

    /**
     * method untuk mendapatkan barang yang empty_on_progress
     * @param string
     * @return object
     */
    public function oneNoWos(string $kode) : object;

    /**
     * method untuk memfilter semua columns
     * @param array
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function filterAllNoWos(array $columns, string $searchVal, string $start, string $length) : object;

    /**
     * method untuk menambahkan stok_ready
     * @param string
     * @param int
     * @return object
     */
    public function addStok(string $kode, int $jumlah) : object;

    /**
     * method untuk mendapatkan laporan `barang`
     * @return object
     */
    public function laporan() : object;
}