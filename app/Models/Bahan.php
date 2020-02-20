<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model {

    protected $table = "bahan";

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
            ->where('kode_jenis_bahan', 'like', "%{$warna}")
            ->where('status_potong', '=', $statusPotong)
            ->get();
    }

    public function scopeGetBahanReady($query) {
        return $query->where('status_potong', false);
    }

    public function jenis_bahan() {
        return $this->belongsTo(JenisBahan::class, 'kode_jenis_bahan', 'kode');
    }

    public function wos() {
        return $this->hasMany(Wos::class, 'id_bahan', 'id');
    }
}
