<?php

namespace App\Repositories\Kain;

use DB;

use App\Models\Kain;

class KainRepository implements KainRepositoryInterface {

    /**
     * method untuk mendapatkan semua `kain`
     * @param string
     * @param string
     * @return object
     */
    public function all(string $start, string $length) : object {
        $start = intval($start);
        $length = intval($length);
        $data = Kain::orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        return $data;
    }

    /**
     * method untuk mendapatkan `kain` berdasarkan kode
     * @param string
     * @return object
     */
    public function get(string $kode) : ?object {
        $data = Kain::getOne($kode)->first();
        return $data;
    }

    /**
     * method untuk membuat `kain`
     * @param object
     * @return object
     */
    public function create(array $data) : object {
        Kain::create($data);
        $createdData = $this->get($data['kode']);
        return $createdData;
    }

    /**
     * method untuk memperbaharui `kain`
     * @param string
     * @param object
     * @return object
     */
    public function edit(string $kode, array $data) : object {
        Kain::edit($kode, $data);
        $updatedData = $this->get($data['kode']);
        return $updatedData;
    }

    /**
     * method untuk menghapus `kain`
     * TODO: sebelum dihapus, harus di record terlebih dahulu
     * @param int
     * @return object
     */
    public function remove(string $kode) : object {
        $deletedData = $this->get($kode)->first();
        Kain::remove($kode);
        return $deletedData;
    }

    /**
     * method untuk mengecheck nama `kain` ada atau tidak
     * @param string
     * @return bool
     */
    public function isNamaKainExist(string $name) : bool {
        $data = $this->listNamaKain();

        if (count($data) > 0) return true;
        else return false;
    }

    /**
     * method untuk mengecheck warna `kain` ada atau tidak
     * @param string
     * @return bool
     */
    public function isWarnaKainExist(string $warna) : bool {
        $data = $this->listWarnaKain();

        if (count($data) > 0) return true;
        else return false;
    }

    /**
     * method untuk mendapatkan semua jenis_bahan dan juga relasinya 'bahan'
     * @return object
     */
    public function allWithRelations() : object {
        $data = Kain::allWithRelations()->get();
        return $data;
    }

    /**
     * method untuk mendapatkan jenis_bahan dan juga relasinya yaitu 'bahan'
     * @param kode
     * @return object
     */
    public function oneWithRelations(string $kode) : object {
        $data = Kain::oneWithRelations($kode)->first();
        return $data;
    }

    /**
     * method untuk mendapatkan list kain
     * @param string_or_null
     * @return object
     */
    public function listNamaKain(?string $warna = null) : object {
        if ($warna != null) {
            $data = DB::table('kain')
                ->select('nama')
                ->groupBy('nama')
                ->where('warna', '=', "${warna}")
                ->get();
        } else {
            $data = DB::table('kain')
                ->select('nama')
                ->groupBy('nama')
                ->get();
        }
        
        return $data;
    }

    /**
     * method untuk mendapatkan list warna berdasarkan nama
     * @param string
     * @return object
     */
    public function listWarnaKain(?string $nama = null) : object {
        if ($nama != null) {
            $data = DB::table('kain')
                ->select('warna')
                ->groupBy('warna')
                ->where('kode', 'like', "%{$nama}%")
                ->get();
        } else {
            $data = DB::table('kain')
                ->select('warna')
                ->groupBy('warna')
                ->get();
        }
        return $data;
    }

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return Kain::class;
    }

    /**
     * method untuk memfilter semua columns
     * @param array
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function filterAll(array $columns, string $searchVal, string $start, string $length) : object {
        $kain = Kain::query();
        $start = intval($start);
        $length = intval($length);

        foreach($columns as $column) {
            if ($column['searchable'] == 'true') {
                $kain->orWhere($column['data'], 'like', "%{$searchVal}%");
            }
            $kain->skip($start)->take($length);
        }

        $data = $kain->get();
        return $data;
    }

    /**
     * method untuk menghitung total records `kain`
     * @return int
     */
    public function countRecords() : int {
        return count(Kain::all());
    }

    /**
     * method untuk mendapatkan list kode `kain`
     * @return object
     */
    public function listKode() : object {
        return Kain::select('kode')->get();
    }
}