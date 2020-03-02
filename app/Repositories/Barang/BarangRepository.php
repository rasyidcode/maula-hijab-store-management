<?php

namespace App\Repositories\Barang;

use DB;
use Illuminate\Support\Facades\Log;

use App\Models\Barang;

class BarangRepository implements BarangRepositoryInterface {
    
    /**
     * method untuk mendapatkan semua barang
     * @return object
     */
    public function all() : object {
        $data = Barang::all();
        return $data;
    }

    /**
     * method untuk mendapatkan semua barang dengan empty_on_progress
     * @return object
     */
    public function allNoWos() : object {
        $data = DB::table('barang')
            ->select(
                'barang.*', 
                DB::raw('(0) as stok_on_progress'),
                DB::raw('IF(barang.stok_ready > barang.treshold, "true", "false") as status_produksi')
            )
            ->orderBy('created_at', 'desc')
            ->get();
        return $data;
    }

    /**
     * method untuk mendapatkan barang yang empty_on_progress
     * @param string
     * @return object
     */
    public function oneNoWos(string $kode) : object {
        $data = DB::table('barang')
            ->select(
                'barang.*', 
                DB::raw('(0) as stok_on_progress'),
                DB::raw('IF(barang.stok_ready > barang.treshold, "true", "false") as status_produksi')
            )
            ->first();
        return $data;
    }

    /**
     * method untuk mendapatkan barang
     * @param kode
     * @return object
     */
    public function get(string $kode) : ?object {
        return Barang::getByKode($kode)->first();
    }

    /**
     * method untuk membuat barang
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        Barang::create($data);
        $createdBarang = $this->get($data['kode']);
        return $createdBarang;
    }

    /**
     * method untuk mengupdate barang
     * @param string
     * @param array
     * @return object
     */
    public function edit(string $kode, array $data) : object {
        Barang::edit($kode, $data);
        $updatedBarang = $this->get($data['kode']);
        return $updatedBarang;
    }

    /**
     * method untuk mendelete barang
     * @param string
     * @return object
     */
    public function remove(string $kode) : object {
        $deletedData = $this->get($kode);
        Barang::remove($kode);
        return $deletedData;
    }

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return Barang::class;
    }

    /**
     * method untuk menghitung jumlah stok yang on_progress
     * @param string
     * @param string
     * @return object
     */
    public function allWithOnProgress(string $start, string $length) : object {
        $start = intval($start);
        $length = intval($length);
        $data = DB::table('barang')
            ->join('wos', 'barang.kode', '=', 'wos.kode_barang')
            ->select(
                'barang.*', 
                DB::raw('(SUM(wos.pcs) - SUM(wos.jumlah_kembali)) as stok_on_progress'),
                DB::raw('IF(barang.stok_ready > barang.treshold, "true", "false") as status_produksi')
            )
            ->groupBy('barang.kode')
            ->skip($start)
            ->take($length)
            ->get();
        
        Log::debug($data);

        return $data;
    }

    /**
     * method untuk mendapatkan satu `barang` dan juga on_progressnya
     * @param string
     * @return object
     */
    public function oneWithOnProgress(string $kode) : object {
        $data = DB::table('barang')
            ->join('wos', 'barang.kode', '=', 'wos.kode_barang')
            ->select(
                'barang.*', 
                DB::raw('(SUM(pcs) - SUM(jumlah_kembali)) as stok_on_progress')
            )
            ->groupBy('barang.kode')
            ->where('kode', '=', $kode)
            ->first();
        
        return $data;
    }

    /**
     * method untuk mendapatkan semua `barang` dan juga relasinya
     * @return object
     */
    public function allWithRelations() : object {
        $data = Barang::allWithRelations();
        return $data;
    }

    /**
     * method untuk mendapatkan satu `barang` dan juga relasinya
     * @param string
     * @return object
     */
    public function oneWithRelations(string $kode) : object {
        $data = Barang::oneWithRelations($kode);
        return $data;
    }

    /**
     * method untuk memfilter semua columns
     * @param array
     * @param string
     * @param string
     * @param string
     * @return object
     */
    public function filterAllNoWos(array $columns, string $searchVal, string $start, string $length) : object {
        $start = intval($start);
        $length = intval($length);

        $induk = DB::table('barang');
        $induk->select(
            'barang.*', 
            DB::raw('(0) as stok_on_progress'),
            DB::raw('IF(barang.stok_ready > barang.treshold, "true", "false") as status_produksi')
        );
        $induk->orderBy('created_at', 'desc');

        foreach($columns as $column) {
            if ($column['searchable'] == 'true') {
                $induk->orWhere('barang.' . $column['data'], 'like', "%{$searchVal}%");
            }
        }

        $induk->skip($start)->take($length);
        $data = $induk->get();
        return $data;
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
        $start = intval($start);
        $length = intval($length);

        $induk = Barang::query();
        $induk->join('wos', 'barang.kode', '=', 'wos.kode_barang');
        $induk->select(
            'barang.*',
            DB::raw('(SUM(wos.pcs) - SUM(wos.jumlah_kembali)) as stok_on_progress'),
            DB::raw('IF(barang.stok_ready > barang.treshold, "true", "false") as status_produksi')
        );
        $induk->groupBy('barang.kode');

        foreach($columns as $column) {
            if ($column['searchable'] == 'true') {
                $induk->orWhere('barang.' . $column['data'], 'like', "%{$searchVal}%");
            }
        }

        $induk->skip($start)->take($length);
        $data = $induk->get();
        // $data = DB::table('barang')
        //     ->join('wos', 'barang.kode', '=', 'wos.kode_barang')
        //     ->select(
        //         'barang.*', 
        //         DB::raw('(SUM(wos.pcs) - SUM(wos.jumlah_kembali)) as stok_on_progress')
        //     )
        //     ->groupBy('barang.kode');
        
        // $start = intval($start);
        // $length = intval($length);

        // foreach($columns as $column) {
        //     if ($column['searchable'] == 'true') {
        //         Log::debug($searchVal);
        //         $data->orWhere('barang.' . $column['data'], 'like', "%$searchVal%");
        //     }
        // }

        // $newData = $data->skip($start)
        //      ->take($length)
        //      ->get();

        // Log::debug($newData);

        return $data;
    }

    /**
     * method untuk menghitung total records `barang`
     * @return int
     */
    public function countRecords() : int {
        return count(Barang::all());
    }

    /**
     * method untuk mendapatkan detail `barang`
     * @param string
     * @return object
     */
    public function detail(string $kode) : object {
        $data = DB::table('barang')
            ->join('wos', 'barang.kode', '=', 'wos.kode_barang')
            ->select(
                'barang.*',
                DB::raw('(SUM(pcs) - SUM(jumlah_kembali)) as stok_on_progress'),
                DB::raw('count(wos.id) as jumlah_wos'),
                DB::raw('IF(barang.stok_ready > barang.treshold, "true", "false") as status_produksi')
            )
            ->where('wos.kode_barang', '=', $kode)
            ->groupBy('barang.kode')
            ->first();

        if ($data == null) {
            $data = $this->oneNoWos($kode);
            $data->jumlah_wos = 0;
        }
        
        return $data;
    }

    /**
     * method untuk menambahkan stok_ready
     * @param string
     * @param int
     * @return object
     */
    public function addStok(string $kode, int $jumlah) : object {
        Barang::where('kode', $kode)
            ->update(['stok_ready' => $jumlah]);
        $updatedStok = $this->get($kode);
        
        return $updatedStok;
    }

}