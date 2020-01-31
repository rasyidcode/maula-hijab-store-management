<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjahit extends Model
{
    protected $table = "penjahit";
    protected $primaryKey = "nomor_hp"; 
    public $incrementing = false;

    protected $guarded = [];

    public function wos() {
        return $this->hasMany('App\Models\Wos', 'nomor_hp_penjahit', 'nomor_hp');
    }
}
