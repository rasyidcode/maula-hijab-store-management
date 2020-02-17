<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model {

    protected $table = "bahan";

    protected $guarded = [];

    public function jenis_bahan() {
        return $this->belongsTo(JenisBahan::class, 'kode_jenis_bahan', 'kode');
    }

    public function wos() {
        return $this->hasMany(Wos::class, 'id_bahan', 'id');
    }
}
