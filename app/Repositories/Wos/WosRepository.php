<?php

namespace App\Repositories\Wos;

use DB;

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
    public function allWithRelations() : object {
        $data = Wos::allWithRelations()->get();
        return $data;
    }

    /**
     * method untuk mendapatkan `wos` dan relasinya
     * @param int
     * @return object
     */
    public function oneWithRelations(int $id) : object {
        $data = Wos::oneWithRelations($id)->first();
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
    public function wosPayment() : object {
        $data = DB::table('wos')
            ->join('penjahit', 'penjahit.no_ktp', '=', 'wos.no_ktp_penjahit')
            ->join('barang', 'barang.kode', '=', 'wos.kode_barang')
            ->join('transaksi_kain', 'transaksi_kain.id', 'wos.id_transaksi_kain')
            ->join('induk', 'barang.kode_induk', '=', 'induk.kode')
            ->select(
                'wos.id',
                'wos.tanggal_bayar',
                'penjahit.nama_lengkap', 
                'barang.kode as kode_barang', 
                'transaksi_kain.kode_kain', 
                'wos.status_bayar',
                'induk.harga_jahit',
                'wos.jumlah_kembali',
                DB::raw('(wos.pcs * induk.harga_jahit) as total_pembayaran')
            )
            ->get();

        return $data;
    }

    /**
     * method untuk membayar `wos`
     * @param int
     * @param array
     * @return object
     */
    public function pay(int $id, array $data) : object {
        Wos::where('id', $id)->update($data);
        $updatedWos = $this->get($id);
        return $updatedWos;
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
        return Wos::class;
    }

    /**
     * method untuk mendapatkan jumlah wos
     * @return object
     */
    public function countRecords() : string {
        return count($this->all());
    }

    /**
     * method untuk mendapatkan data dengan kode_barang tertentu ada atau tidak
     * @param string
     * @return object
     */
    public function isKodeBarangLinked(string $kode) : bool {
        $data = Wos::where('kode_barang', $kode)->get();

        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * method untuk mendapatkan semua `wos` untuk datatable
     * @param string
     * @param string
     * @return object
     */
    public function allDatatable(string $start, string $length) : object {
        $start = intval($start);
        $length = intval($length);

        $data = DB::table('wos')
            ->leftJoin('penjahit', 'penjahit.no_ktp', '=', 'wos.no_ktp_penjahit')
            ->leftJoin('barang', 'barang.kode', '=', 'wos.kode_barang')
            ->select(
                'penjahit.nama_lengkap',
                'barang.kode as kode_barang',
                'wos.*',
                DB::raw('(wos.yard / wos.pcs) as demand'),
                DB::raw('(wos.pcs - wos.jumlah_kembali) as on_progress')
            )
            ->where('wos.status_jahit', 0)
            ->skip($start)
            ->take($length)
            ->get();

        return $data;
    }

    /**
     * method untuk mendapatkan mendapatkan detail `wos` berdasarkan id
     * @param int
     * @return object
     */
    public function detail(int $id) : object {
        $data = Wos::with('barang')
            ->with('penjahit')
            ->where('id', $id)
            ->first();
        return $data;
    }

}