<?php

namespace App\Repositories\Penjahit;

use App\Models\Penjahit;

class PenjahitRepository implements PenjahitRepositoryInterface {

    /**
     * method untuk mendapatkan semua `penjahit`
     * @return object
     */
    public function all() : object {
        return Penjahit::all();
    }

    /**
     * method untuk mendapatkan `penjahit`
     * @param string
     * @return object
     */
    public function get(string $noKtp) : ?object {
        return Penjahit::getBy($noKtp)->first();
    }

    /**
     * method untuk membuat `penjahit`
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $pjht = Penjahit::create($data);
        $createdData = $this->get($pjht->no_ktp);
        return $createdData;
    }

    /**
     * method untuk mengupdate `penjahit`
     * @param string
     * @param array
     * @return object
     */
    public function edit(string $noKtp, array $data) : object {
        Penjahit::edit($noKtp, $data);
        $updatedData = $this->get($noKtp);
        return $updatedData;
    }

    /**
     * method untuk mendelete `penjahit`
     * @param string
     * @return object
     */
    public function remove(string $noKtp) : object {
        $deletedData = $this->get($noKtp);
        Penjahit::remove($noKtp);
        return $deletedData;
    }

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return Penjahit::class;
    }

    /**
     * method untuk mendapatkan semua `penjahit` dan juga `wos`nya
     * @return object
     */
    public function allWithWos() : object {
        return Penjahit::allWithWos()->get();
    }

    /**
     * method untuk mendapatkan `penjahit` dan juga semua `wos`nya
     * @param string
     * @return object
     */
    public function oneWithWos(string $noKtp) : object {
        return Penjahit::oneWithWos($noKtp)->first();
    }


}