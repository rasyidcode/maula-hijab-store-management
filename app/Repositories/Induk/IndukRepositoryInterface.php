<?php

namespace App\Repositories\Induk;

interface IndukRepositoryInterface {

    /**
     * method untuk mendapatkan semua induk
     * @return object
     */
    public function all() : object;

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

}