<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBahan extends Model
{
    protected $table = 'jenis_bahan';
    protected $primaryKey = 'kode';
    public $incrementing = false;

    protected $guarded = [];

    public function bahan() {
        return $this->hasMany(Bahan::class, 'kode_jenis_bahan', 'kode');
    }
}
