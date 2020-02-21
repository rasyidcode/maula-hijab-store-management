<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Induk extends Model
{
    protected $table = "induk";
    protected $primaryKey = "kode";
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

    public function barang() {
        return $this->hasMany(Barang::class, 'kode_induk', 'kode');
    }
}
