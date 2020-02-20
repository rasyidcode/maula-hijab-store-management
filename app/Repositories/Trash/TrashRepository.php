<?php

namespace App\Repositories\Trash;

use App\Models\Trash;

class TrashRepository implements TrashRepositoryInterface {

    /**
     * method untuk mendapatkan semua `trash`
     * @return object
     */
    public function all() : object {
        return Trash::all();
    }

    /**
     * method untuk mendapatkan `trash` berdasarkan id
     * @param integer
     * @return object
     */
    public function get(int $id) : object {
        return Trash::find($id);
    }

    /**
     * method untuk membuat `trash` baru
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $ts = Trash::create($data);
        $createdData = $this->get($ts->id);
        return $createdData;
    }

    /**
     * method untuk mengupdate `trash`
     * @param integer
     * @param array
     * @return object
     */
    public function update(int $id, array $data) : object {
        Trash::update($id, $data);
        $updatedData = $this->get($id);
        return $updatedData;
    }

    /**
     * method untuk menghapus `trash`
     * @param integer
     * @return object
     */
    public function delete(int $id) : object {
        $deletedData = $this->get($id);
        Trash::delete($id);
        $res = new \stdClass();
        $res->message = "Data telah dihapus!";
        $res->data = $deletedData;
        return $res;
    }

}