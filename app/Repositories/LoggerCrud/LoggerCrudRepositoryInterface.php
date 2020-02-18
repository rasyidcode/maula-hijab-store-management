<?php

namespace App\Repositories\LoggerCrud;

interface LoggerCrudRepositoryInterface {

    public function opCreate() : string;
    public function opUpdate() : string;
    public function opGet() : string;
    public function opDelete() : string;

    /**
     * method untuk mendapatkan semua logger_crud
     * @return object
     */
    public function all() : object;

    /**
     * method untuk mendapatkan logger_crud berdasarkan id
     * @param string
     * @return object
     */
    public function get(int $id) : object;

    /**
     * method untuk mendapatkan logger_crud pada tanggal tertentu
     * @param date
     * @return object
     */
    public function getByDate(string $date) : object;

    /**
     * method untuk membuat logger_crud
     * @param object
     * @return object
     */
    public function create(array $loggerCrud) : object;

    /**
     * method untuk memperbaharui logger_crud
     * @param string
     * @param object
     * @return object
     */
    public function update(int $id, array $loggerCrud) : object;

    /**
     * method untuk menghapus logger_crud
     * @param int
     * @return object
     */
    public function delete(int $id) : object;

}