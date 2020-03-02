<?php

namespace App\Repositories\Induk;

interface IndukRepositoryInterface {

    /**
     * method untuk mendapatkan semua induk
     * @param string
     * @param string
     * @return object
     */
    public function all(string $start, string $length) : object;

    /**
     * method untuk mendapatkan induk
     * @param string
     * @return object
     */
    public function get(string $kode) : ?object;

    /**
     * method untuk membuat induk
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengupdate induk
     * @param string
     * @param array
     * @return object
     */
    public function edit(string $kode, array $data) : object;

    /**
     * method untuk mendelete induk
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
     * method untuk memfilter semua columns
     * @param array
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function filterAll(array $columns, string $searchVal, string $start, string $length) : object;

    /**
     * method untuk menghitung total records `induk`
     * @return int
     */
    public function countRecords() : int;

    /**
     * method untuk mendapatkan list kode `induk`
     * @return object
     */
    public function listKode() : object;

    /**
     * method untuk mendapatkan detail dari satu `induk`
     * @param string
     * @return object
     */
    public function detail(string $kode) : object;

}