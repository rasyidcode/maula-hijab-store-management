<?php

namespace App\Repositories\Induk;

use DB;

use App\Models\Induk;

class IndukRepository implements IndukRepositoryInterface {

    /**
     * method untuk mendapatkan semua induk
     * @param string
     * @param string
     * @return object
     */
    public function all(string $start, string $length) : object {
        $start = intval($start);
        $length = intval($length);
        $data = Induk::orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        return $data;
    }

    /**
     * method untuk mendapatkan induk
     * @param string
     * @return object
     */
    public function get(string $kode) : ?object {
        $data = Induk::getByKode($kode)->first();
        return $data;
    }

    /**
     * method untuk membuat induk
     * @param array
     * @return object
     */
    public function create(array $data) : object {
        $idk = Induk::create($data);
        $createdData = $this->get($idk->kode);
        return $createdData;
    }

    /**
     * method untuk mengupdate induk
     * @param string
     * @param array
     * @return object
     */
    public function edit(string $kode, array $data) : object {
        Induk::edit($kode, $data);
        $updatedData = $this->get($data['kode']);
        return $updatedData;
    }

    /**
     * method untuk mendelete induk
     * @param string
     * @return object
     */
    public function remove(string $kode) : object {
        $deletedData = $this->get($kode);
        Induk::remove($kode);
        return $deletedData;
    }

    /**
     * method untuk mendapatkan nama model
     * @return string
     */
    public function getModelName() : string {
        return Induk::class;
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
        $induk = Induk::query();
        $start = intval($start);
        $length = intval($length);

        foreach($columns as $column) {
            if ($column['searchable'] == 'true') {
                $induk->orWhere($column['data'], 'like', "%{$searchVal}%");
            }
            $induk->skip($start)->take($length);
        }

        $data = $induk->get();
        return $data;
    }

    /**
     * method untuk menghitung total records `kain`
     * @return int
     */
    public function countRecords() : int {
        return count(Induk::all());
    }

    /**
     * method untuk mendapatkan list kode `kain`
     * @return object
     */
    public function listKode() : object {
        return Induk::select('kode')->get();
    }

    /**
     * method untuk mendapatkan detail dari satu `induk`
     * @param string
     * @return object
     */
    public function detail(string $kode) : object {
        $data = DB::table('induk')
            ->select(
                'kode',
                'harga_basic',
                'harga_jahit',
                'hpp_shopee',
                'hpp_lazada',
                'dfs_shopee',
                'dfs_lazada',
                'created_at',
                'updated_at',
                DB::raw('(dfs_shopee * 0.97) as min_fs_shopee'),
                DB::raw('(dfs_shopee * 0.85) as campaign_shopee'),
                DB::raw('((dfs_shopee * 0.85) / 0.70) as ecer_shopee'),
                DB::raw('(dfs_lazada * 0.97) as min_fs_lazada'),
                DB::raw('(dfs_lazada * 0.85) as campaign_lazada'),
                DB::raw('((dfs_lazada * 0.85) / 0.70) as ecer_lazada')
            )
            ->where('kode', $kode)
            ->first();
        
        $data->min_fs_shopee = intval($data->min_fs_shopee);
        $data->campaign_shopee = intval($data->campaign_shopee);
        $data->ecer_shopee = intval($data->ecer_shopee);
        $data->min_fs_lazada = intval($data->min_fs_lazada);
        $data->campaign_lazada = intval($data->campaign_lazada);
        $data->ecer_lazada = intval($data->ecer_lazada);
        
        return $data;
    }

}