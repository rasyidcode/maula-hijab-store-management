<?php

namespace App\Repositories\Penjahit;

interface PenjahitRepositoryInterface {

    /**
     * method untuk mendapatkan semua `penjahit`
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan `penjahit`
     * @param string
     * @return object
     */
    public function get(string $noKtp) : ?object;

    /**
     * method untuk membuat `penjahit`
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengupdate `penjahit`
     * @param string
     * @param array
     * @return object
     */
    public function edit(string $noKtp, array $data) : object;

    /**
     * method untuk mendelete `penjahit`
     * @param string
     * @return object
     */
    public function remove(string $noKtp) : object;

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string;

    /**
     * method untuk mendapatkan semua `penjahit` dan juga `wos`nya
     * @return object
     */
    public function allWithWos() : object;

    /**
     * method untuk mendapatkan `penjahit` dan juga semua `wos`nya
     * @param string
     * @return object
     */
    public function oneWithWos(string $noKtp) : object;

    /**
     * method untuk mendapatkan semua `penjahit` untuk datatable
     * @param string
     * @param string
     * @return object
     */
    public function allDatatable(string $start, string $length) : object;

    /**
     * method untuk memfilter `penjahit` untuk datatable
     * @param array
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function filterAll(array $columns, string $serachVal, string $string, string $length) : object;

    /**
     * method untuk menghitung total records `penjahit`
     * @return int
     */
    public function countRecords() : int;
    
}