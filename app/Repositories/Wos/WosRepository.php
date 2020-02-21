<?php

namespace App\Repositories\Wos;

use App\Models\Wos;

class WosRepository implements WosRepositoryInterface {

    /**
     * method untuk mendapatkan semua `wos`
     * @return object
     */
    public function all() : object {
        return Wos::all();
    }

    /**
     * method untuk mendapatkan `wos`
     * @param int
     * @return object
     */
    public function get(int $id) : ?object {
        return Wos::find($id);
    }

    /**
     * method untuk mendapatkan semua `wos` dan relasinya
     * @return object
     */
    public function withRelations() : object {
        $data = Wos::withRelations()->get();
        return $data;
    }

    /**
     * method untuk mendapatkan `wos` dan relasinya
     * @param int
     * @return object
     */
    public function withRelation(int $id) : object {
        $data = Wos::withRelation($id)->first();
        return $data;
    }

    /**
     * method untuk membuat `wos`
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $ws = Wos::create($data);
        $createdData = $this->get($ws->id);
        return $createdData;
    }

    /**
     * method untuk mengupdate `wos`
     * @param int
     * @param array
     * @return object
     */
    public function edit(int $id, array $data) : object {
        Wos::edit($id, $data);
        $updatedData = $this->get($id);
        return $updatedData;
    }

    /**
     * method untuk menghapus `wos`
     * @param int
     * @return object
     */
    public function remove(int $id) : object {
        $deletedData = $this->get($id);
        Wos::remove($id);
        return $deletedData;
    }

    /**
     * method untuk mendapatkan `wos` yang sudah completed dan belum dibayar
     * @return object
     */
    public function wosToPay() : object {
        $data = Wos::wosToPay();
        return $data;
    }

    /**
     * method untuk membayar `wos`
     * @param array
     * @return object
     */
    public function pay(array $data) : object {
        // pay wos
    }

    public function onProgress(string $kodeBarang) : object {
        $data = DB::table('wos')
            ->select(DB::raw('SUM(pcs) as total_pcs'), DB::raw('SUM(jumlah_kembali) as total_jumlah_kembali'))
            ->where('kode_barang', $kodeBarang)
            ->get();

        return $data;
    }

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return Bahan::class;
    }

}