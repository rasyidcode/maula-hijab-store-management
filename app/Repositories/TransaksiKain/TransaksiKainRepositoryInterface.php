<?php

namespace App\Repositories\Bahan;

interface BahanRepositoryInterface {

    /**
     * method untuk mendapatkan semua bahan
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan bahan
     * @param integer
     * @return object
     */
    public function get(int $id) : ?object;

    /**
     * method untuk mendapatkan id, yard berdasarkan nama dan warna bahan yang telah
     * di input oleh user
     * @param string
     * @param string
     * @return object
     */
    public function getYard(string $nama, string $warna) : object;

    /**
     * method untuk membuat bahan
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengupdate bahan
     * @param integer
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object;

    /**
     * method untuk menghapus bahan
     * @param integer
     * @return object
     */
    public function remove(int $id) : object;

    /**
     * method untuk mengganti status_potong `bahan`
     * @param bool
     * @return object
     */
    public function setStatusPotong(int $id, bool $value) : object;

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string;

    /**
     * method untuk mengecheck status_potong `bahan`
     * @param integer
     * @return object
     */
    public function checkStatusPotong(int $id) : object;

    /**
     * method untuk mendapatkan jumlah bahan yang belum dipotong `bahan`
     * @return int
     */
    public function countBahanBelumDiPotong() : int;

    /**
     * method untuk mendapatkan yard `bahan` berdasarkan id
     * @param int
     * @return int
     */
    public function getBahanYard(int $id) : int;

}