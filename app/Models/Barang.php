<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model {
    protected $table = "barang";
    protected $primarykey = "kode";
    public $incrementing = false;

    protected $guarded = [];

    public function scopeGetByKode($query, string $kode) {
        return $query->where('kode', $kode);
    }

    public function scopeEdit($query, string $kode, array $data) {
        $query->where('kode', $kode)->update($data);
    }

    public function scopeRemove($query, string $kode) {
        $query->where('kode', $kode)->delete();
    }

    public function scopeAllWithRelations($query) : object {
        return $query
            ->with('induk')
            ->with('kain')
            ->get();
    }

    public function scopeOneWithRelations($query, string $kode) : object {
        return $query
            ->with('induk')
            ->with('kain')
            ->where('kode', $kode)
            ->first();
    }

    public function induk() {
        return $this->belongsTo(Induk::class, 'kode_induk', 'kode');
    }

    public function wos() {
        return $this->hasMany(Wos::class, 'kode_barang', 'kode');
    }

    public function kain() {
        return $this->belongsTo(Kain::class, 'kode_kain', 'kode');
    }
}
