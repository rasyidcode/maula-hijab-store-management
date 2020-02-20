<?php

namespace App\Repositories\Trash;

interface TrashRepositoryInterface {

    /**
     * method untuk mendapatkan semua `trash`
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan `trash` berdasarkan id
     * @param integer
     * @return object
     */
    public function get(int $id) : object;

    /**
     * method untuk membuat `trash` baru
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengupdate `trash`
     * @param integer
     * @param array
     * @return object
     */
    public function update(int $id, array $data) : object;

    /**
     * method untuk menghapus `trash`
     * @param integer
     * @return object
     */
    public function delete(int $id) : object;


}