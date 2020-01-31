<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model {
    protected $table = "barang";
    protected $primarykey = "kode";
    public $incrementing = false;

    protected $guarded = [];

    public function induk() {
        return $this->belongsTo('App\Models\Induk', "kode_induk", "kode");
    }

    public function bahan() {
        return $this->belongsTo('App\Models\Bahan', "id_bahan", "id");
    }
}
