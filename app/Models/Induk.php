<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Induk extends Model
{
    protected $table = "induk";
    protected $primaryKey = "kode";
    public $incrementing = false;

    protected $guarded = [];

    public function barang() {
        return $this->hasMany(Barang::class, 'kode_induk', 'kode');
    }
}
