<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model {

    protected $table = "bahan";

    protected $guarded = [];

    public function barang() {
        return $this->hasMany('App\Models\Barang', "id_bahan", "id");
    }
}
