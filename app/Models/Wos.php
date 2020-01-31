<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wos extends Model
{
    protected $table = "wos";
    protected $primaryKey = "kode"; 
    public $incrementing = false;

    protected $guarded = [];

    public function penjahit() {
        return $this->belongsTo('App\Models\Penjahit', 'nomor_hp_penjahit', 'nomor_hp');
    }
}
