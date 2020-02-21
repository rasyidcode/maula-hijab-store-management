<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKain extends Model {

    protected $table = "transaksi_kain";

    protected $guarded = [];

    public function scopeEdit($query, int $id, array $data) {
        $query->where('id', $id)->update($data);
    }

    public function scopeRemove($query, int $id) {
        $query->where('id', $id)->delete();
    }

    public function scopeGetYard($query, string $nama, string $warna, bool $statusPotong) : object {
        return $query->select('id', 'yard')
            ->where('kode_jenis_bahan', 'like', "%{$nama}%")
            ->where('kode_jenis_bahan', 'like', "%{$warna}%")
            ->where('status_potong', '=', $statusPotong)
            ->get();
    }

    public function scopeGetBahanReady($query) {
        return $query->where('status_potong', false);
    }

    public function scopeSetStatusPotong($query, int $id, bool $value) {
        $query->find($id)->update(['status_potong' => $value]);
    }

    public function jenis_bahan() {
        return $this->belongsTo(Kain::class, 'kode_kain', 'kode');
    }

    public function wos() {
        return $this->hasMany(Wos::class, 'id_bahan', 'id');
    }
}
