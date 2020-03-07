<?php

namespace App\Repositories\Warna;

interface WarnaRepositoryInterface {
    
    /**
     * method untuk mendapatkan semua `warna`
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan satu `warna`
     * @param int
     * @return object
     */
    public function get(int $id) : ?object;

    /**
     * method untuk membuat `warna`
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengedit `warna`
     * @param int
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object;

    /**
     * method untuk menghapus `warna`
     * @param int
     * @return object
     */
    public function remove(int $id) : object;

    /**
     * method untuk mendapatkan nama model `warna`
     * @return string
     */
    public function modelName() : string;

    /**
     * method untuk mendapatkan semua warna dengan paginate
     * @param int
     * @param int
     * @return object
     */
    public function paginate(int $start, int $length) : object;

}