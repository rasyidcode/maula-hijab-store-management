<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model {
    
    protected $table = "pemesanan";

    protected $guarded = [];

    public function produk() {
        return $this->hasMany(Produk::class, "id_pemesanan", "id");
    }
}
