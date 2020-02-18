<?php

namespace App\Repositories\LoggerCrud;

use App\Models\LoggerCrud;
use App\Repositories\LoggerCrud\LoggerCrudRepositoryInterface;

class LoggerCrudRepository implements LoggerCrudRepositoryInterface {

    public function opCreate() : string {
        return LoggerCrud::CREATE;
    }

    public function opUpdate() : string {
        return LoggerCrud::UPDATE;
    }

    public function opGet() : string {
        return LoggerCrud::GET;
    }

    public function opDelete() : string {
        return LoggerCrud::GET;
    }

    /**
     * method untuk mendapatkan semua logger_crud
     * @return object
     */
    public function all() : object {
        return LoggerCrud::all();
    }

    /**
     * method untuk mendapatkan logger_crud berdasarkan id
     * @param string
     * @return object
     */
    public function get(int $id) : object {
        return LoggerCrud::find($id);
    }

    /**
     * method untuk mendapatkan logger_crud pada tanggal tertentu
     * @param date
     * @return object
     */
    public function getByDate(string $date) : object {
        $data = LoggerCrud::getByDate($date)->get();
        return $data;
    }

    /**
     * method untuk membuat logger_crud
     * @param object
     * @return object
     */
    public function create(array $data) : object {
        $lgc = LoggerCrud::create($data);
        $createdLoggerCrud = $this->get($lgc->id);
        return $createdLoggerCrud;
    }

    /**
     * method untuk memperbaharui logger_crud
     * @param string
     * @param object
     * @return object
     */
    public function update(int $id, array $data) : object {
        LoggerCrud::Update($id, $data);
        $updatedLoggerCrud = $this->get($id);
        return $updatedLoggerCrud;
    }

    /**
     * method untuk menghapus logger_crud
     * @param int
     * @return object
     */
    public function delete(int $id) : object {
        LoggerCrud::Delete($id);
        $res = new \stdClass();
        $res->message = "Logger Crud dengan id: {$id}, berhasil dihapus";
        return $res;
    }

}