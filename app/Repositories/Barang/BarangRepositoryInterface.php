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
     * @return object
     */
    public function allWithReadyAndProgress() : object;

    /**
     * method untuk mendapatkan satu `barang` dan juga on_progressnya
     * @param string
     * @return object
     */
    public function oneWithReadyAndProgress(string $kode) : object;

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
}