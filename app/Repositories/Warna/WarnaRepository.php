<?php

namespace App\Repositories\Warna;

use App\Models\Warna;

class WarnaRepository implements WarnaRepositoryInterface {

    /**
     * method untuk mendapatkan semua `warna`
     * @return object
     */
    public function all() : object {
        return Warna::latest()->get();
        
    }

    /**
     * method untuk mendapatkan satu `warna`
     * @param int
     * @return object
     */
    public function get(int $id) : ?object {
        return Warna::find($id);
    }

    /**
     * method untuk membuat `warna`
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $createdData = Warna::create($data);
        return $this->get($createdData->id);
    }

    /**
     * method untuk mengedit `warna`
     * @param int
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object {
        Warna::where('id', $id)->update($data);
        return $this->get($id);
    }

    /**
     * method untuk menghapus `warna`
     * @param int
     * @return object
     */
    public function remove(int $id) : object {
        $data = $this->get($id);
        Warna::where('id', $id)->delete();
        return $data;
    }
    
    /**
     * method untuk mendapatkan nama model `warna`
     * @return string
     */
    public function modelName() : string {
        return Warna::class;
    }

    /**
     * method untuk mendapatkan semua warna dengan paginate
     * @param int
     * @param int
     * @return object
     */
    public function paginate(int $start, int $length) : object {
        $data = Warna::skip($start)->take($length)->latest()->get();
        return $data;
    }
}