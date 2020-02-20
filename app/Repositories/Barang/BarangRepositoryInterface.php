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
    public function get(string $kode) : object;

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
    public function update(string $kode, array $data) : object;

    /**
     * method untuk mendelete barang
     * @param string
     * @return object
     */
    public function delete(string $kode) : object;

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string;

    /**
     * method untuk menghitung jumlah stok yang on_progress
     * @return integer
     */
    public function countOnProgress() : integer;

}