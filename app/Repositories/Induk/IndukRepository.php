<?php

namespace App\Repositories\Induk;

use App\Models\Induk;

class IndukRepository implements IndukRepositoryInterface {

    /**
     * method untuk mendapatkan semua induk
     * @return object
     */
    public function all() : object {
        return Induk::all();
    }

    /**
     * method untuk mendapatkan induk
     * @param string
     * @return object
     */
    public function get(string $kode) : ?object {
        $data = Induk::getByKode($kode)->first();
        return $data;
    }

    /**
     * method untuk membuat induk
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $idk = Induk::create($data);
        $createdData = $this->get($idk->kode);
        return $createdData;
    }

    /**
     * method untuk mengupdate induk
     * @param string
     * @param array
     * @return object
     */
    public function edit(string $kode, array $data) : object {
        Induk::edit($kode, $data);
        $updatedData = $this->get($data['kode']);
        return $updatedData;
    }

    /**
     * method untuk mendelete induk
     * @param string
     * @return object
     */
    public function remove(string $kode) : object {
        $deletedData = $this->get($kode);
        Induk::remove($kode);
        return $deletedData;
    }

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return Induk::class;
    }

}