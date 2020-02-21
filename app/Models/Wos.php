<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wos extends Model {

    protected $table = "wos";
    protected $guarded = [];

    public function scopeWithRelations($query) : object {
        return $query->with('barang')->with('bahan')->with('penjahit')->orderBy('created_at', 'desc');
    }

    public function scopeWithRelation($query, int $id) : object {
        return $query
            ->with('barang')
            ->with('bahan')
            ->with('penjahit')
            ->where('id', $id)
            ->orderBy('created_at', 'desc');
    }

    public function scopeEdit($query, int $id, array $data) {
        $query->where('id', $id)->update($data);
    }

    public function scopeRemove($query, int $id) {
        $query->where('id', $id)->delete();
    }

    public function scopeWosToPay($query) : object {
        return $query
            ->select('nama_penjahit', 'tanggal_bayar', 'kode_barang', 'nama_bahan', 'pcs', 'status_bayar')
            ->where('status_jahit', true)
            ->where('status_bayar', false)
            ->get();
    }

    public function penjahit() {
        return $this->belongsTo(Penjahit::class, 'no_ktp_penjahit', 'no_ktp');
    }

    public function barang() {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }

    public function bahan() {
        return $this->belongsTo(Bahan::class, 'id_bahan', 'id');
    }
}
