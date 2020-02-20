<?php

namespace App\Repositories\Penjahit;

interface PenjahitRepositoryInterface {

    /**
     * method untuk mendapatkan semua `penjahit`
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan semua `penjahit` dan juga `wos`nya
     * @return object
     */
    public function allWithWos() : object;

    /**
     * method untuk mendapatkan `penjahit`
     * @param string
     * @return object
     */
    public function get(string $noKtp) : object;

    /**
     * method untuk mendapatkan `penjahit` dan juga semua `wos`nya
     * @param string
     * @return object
     */
    public function oneWithWos(string $noKtp) : object;

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
    public function update(string $noKtp, array $data) : object;

    /**
     * method untuk mendelete `penjahit`
     * @param string
     * @return object
     */
    public function delete(string $noKtp) : object;

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string;
    
}