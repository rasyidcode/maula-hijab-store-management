<?php

namespace App\Repositories\Bahan;

use DB;

use App\Models\Bahan;

class BahanRepository implements BahanRepositoryInterface {

        /**
     * method untuk mendapatkan semua `bahan`
     * @return object
     */
    public function all() : object {
        return Bahan::latest()->get();
    }

    /**
     * method untuk mendapatkan satu `bahan`
     * @param int
     * @return object
     */
    public function get(int $id) : ?object {
        return Bahan::find($id);
    }

    /**
     * method untuk menambahkan `bahan`
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $createdData = Bahan::create($data);
        return $this->get($createdData->id);
    }

    /**
     * method untuk mengedit `bahan`
     * @param int
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object {
        Bahan::where('id', $id)->update($data);
        return $this->get($id);
    }

    /**
     * method untuk menghapus `bahan`
     * @param int
     * @return object
     */
    public function remove(int $id) : object {
        $deletedData = $this->get($id);
        Bahan::where('id', $id)->delete();
        return $deletedData;
    }

    /**
     * method untuk mendapatkan `bahan` berdasarkan start dan length
     * @param int
     * @param int
     * @return object
     */
    public function paginate(int $start, int $length) : object {
        return Bahan::latest()->skip($start)->take($length)->get();
    }

    /**
     * method untuk mendapatkan nama model `bahan`
     * @return string
     */
    public function modelName() : string {
        return Bahan::class;
    }

}