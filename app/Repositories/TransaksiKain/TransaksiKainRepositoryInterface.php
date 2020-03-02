<?php

namespace App\Repositories\TransaksiKain;

interface TransaksiKainRepositoryInterface {

    /**
     * method untuk mendapatkan semua `transaksi_kain`
     * @return object
     */
    public function all(string $start, string $length) : object;

    /**
     * method untuk mendapatkan `transaksi_kain`
     * @param integer
     * @return object
     */
    public function get(int $id) : ?object;

    /**
     * method untuk mendapatkan id, yard berdasarkan nama dan warna `transaksi_kain` yang telah
     * di input oleh user
     * @param string
     * @param string
     * @return object
     */
    public function getYard(string $nama, string $warna) : object;

    /**
     * method untuk membuat `transaksi_kain`
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengupdate `transaksi_kain`
     * @param integer
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object;

    /**
     * method untuk menghapus `transaksi_kain`
     * @param integer
     * @return object
     */
    public function remove(int $id) : object;

    /**
     * method untuk mengganti status_potong `transaksi_kain`
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
     * method untuk mengecheck status_potong `transaksi_kain``
     * @param integer
     * @return object
     */
    public function checkStatusPotong(int $id) : object;

    /**
     * method untuk mendapatkan jumlah `transaksi_kain` yang belum dipotong `transaksi_kain``
     * @return int
     */
    public function countTransaksiKainBelumDiPotong() : int;

    /**
     * method untuk mendapatkan yard `transaksi_kain`` berdasarkan id
     * @param int
     * @return int
     */
    public function getBahanYard(int $id) : int;

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
     * method untuk menghitung total records `kain`
     * @return int
     */
    public function countRecords() : int;

    /**
     * method untuk mendapatkan semua yard berdasarkan `kode_kain`
     * @param string
     * @return object
     */
    public function getYards(string $kodeKain) : object;

}