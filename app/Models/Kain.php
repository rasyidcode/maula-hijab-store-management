<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kain extends Model {
    protected $table = 'kain';
    protected $primaryKey = 'kode';
    public $incrementing = false;

    protected $guarded = [];

    /* START OF SCOPE */
    public function scopeGetOne($query, string $kode) {
        return $query->where('kode', $kode);
    }

    public function scopeEdit($query, string $kode, array $data) {
        $query->where('kode', $kode)->update($data);
    }

    public function scopeRemove($query, string $kode) {
        $query->where('kode', $kode)->delete();
    }

    public function scopeGetWithTransaksiKain($query, string $kode) {
        return $query->with('transaksi_kain')->where('kode', $kode);
    }

    public function scopeGetAllWithTransaksiKain($query) {
        return $query->with('transaksi_kain');
    }
    /* END OF SCOPE */

    public function transaksi_kain() {
        return $this->hasMany(Bahan::class, 'kode_kain', 'kode');
    }

    public function barang() {
        return $this->hasMany(Barang::class, 'kode_kain', 'kode');
    }
}
