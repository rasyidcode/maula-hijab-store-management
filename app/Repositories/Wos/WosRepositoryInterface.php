<?php

namespace App\Repositories\Wos;

interface WosRepositoryInterface {

    /**
     * method untuk mendapatkan semua `wos`
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan `wos`
     * @param int
     * @return object
     */
    public function get(int $id) : ?object;

    /**
     * method untuk mendapatkan semua `wos` dan relasinya
     * @return object
     */
    public function withRelations() : object;

    /**
     * method untuk mendapatkan `wos` dan relasinya
     * @param int
     * @return object
     */
    public function withRelation(int $id) : object;

    /**
     * method untuk membuat `wos`
     * @param array
     * @return object
     */
    public function create(array $data) : object;

    /**
     * method untuk mengupdate `wos`
     * @param int
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object;

    /**
     * method untuk menghapus `wos`
     * @param int
     * @return object
     */
    public function remove(int $id) : object;

    /**
     * method untuk mendapatkan `wos` yang sudah completed dan belum dibayar
     * @return object
     */
    public function wosToPay() : object;

    /**
     * method untuk membayar `wos`
     * @param array
     * @return object
     */
    public function pay(array $data) : object;

    /**
     * method untuk mendapatkan `wos` yang lagi di progress
     * @param string
     * @return object
     */
    public function onProgress(string $kodeBarang) : object;

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string;
}