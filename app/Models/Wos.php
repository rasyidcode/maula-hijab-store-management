<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wos extends Model
{
    protected $table = "wos";
    protected $guarded = [];

    public function penjahit() {
        return $this->belongsTo('App\Models\Penjahit', 'no_ktp_penjahit', 'no_ktp');
    }

    public function barang() {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }

    public function bahan() {
        return $this->belongsTo(Bahan::class, 'id_bahan', 'id');
    }
}
