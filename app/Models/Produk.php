<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model {

    protected $table = "produk";

    protected $guarded = [];

    public function pemesanan() {
        return $this->belongsTo(Pemesanan::class, "id_pemesanan", "id");
    }
}
