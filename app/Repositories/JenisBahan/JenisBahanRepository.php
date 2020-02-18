<?php

namespace App\Repositories\JenisBahan\JenisBahanRepository;

use App\Models\JenisBahan;

class JenisBahanRepository implements JenisBahanRepositoryInterface {

    /**
     * method untuk mendapatkan semua jenis_bahan
     * @return object
     */
    public function all() : object {
        return JenisBahan::all();
    }

    /**
     * method untuk mendapatkan jenis_bahan berdasarkan kode
     * @param string
     * @return object
     */
    public function get(string $kode) : object {
        
    }

    /**
     * method untuk membuat jenis_bahan
     * @param object
     * @return object
     */
    public function create(object $jenis_bahan) : object {

    }

    /**
     * method untuk memperbaharui jenis_bahan
     * @param string
     * @param object
     * @return object
     */
    public function update(string $kode, object $jenis_bahan) : object {

    }

    /**
     * method untuk menghapus jenis_bahan
     * @param int
     * @return object
     */
    public function delete(string $kode) : object {

    }

}