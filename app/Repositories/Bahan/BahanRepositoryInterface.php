<?php

namespace App\Repositories\Bahan;

interface BahanRepositoryInterface {

    /**
     * method untuk mendapatkan semua `bahan`
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan satu `bahan`
     * @param int
     * @return object
     */
    public function get(int $id) : ?object;

    /**
     * method untuk menambahkan `bahan`
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengedit `bahan`
     * @param int
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object;

    /**
     * method untuk menghapus `bahan`
     * @param int
     * @return object
     */
    public function remove(int $id) : object;

    /**
     * method untuk mendapatkan `bahan` berdasarkan start dan length
     * @param int
     * @param int
     * @return object
     */
    public function paginate(int $start, int $length) : object;

    /**
     * method untuk mendapatkan nama model `bahan`
     * @return string
     */
    public function modelName() : string;
}