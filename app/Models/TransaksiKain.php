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
            ->where('kode_kain', 'like', "%{$nama}%")
            ->where('kode_kain', 'like', "%{$warna}%")
            ->where('status_potong', '=', $statusPotong)
            ->get();
    }

    public function scopeTransaksiKainReady($query) {
        return $query->where('status_potong', false);
    }

    public function scopeSetStatusPotong($query, int $id, bool $value) {
        $query->find($id)->update(['status_potong' => $value]);
    }

    public function kain() {
        return $this->belongsTo(Kain::class, 'kode_kain', 'kode');
    }

    public function wos() {
        return $this->hasOne(Wos::class, 'id_transaksi_kain', 'id');
    }
}
