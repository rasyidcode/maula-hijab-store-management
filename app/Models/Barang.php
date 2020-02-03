<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model {
    protected $table = "barang";
    protected $primarykey = "kode";
    public $incrementing = false;

    protected $guarded = [];

    public function induk() {
        return $this->belongsTo(Induk::class, 'kode_induk', 'kode');
    }
}
