<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjahit extends Model
{
    protected $table = "penjahit";
    protected $primaryKey = "no_ktp"; 
    public $incrementing = false;

    protected $guarded = [];

    public function scopeGetBy($query, string $noKtp) : object {
        return $query->where('no_ktp', $noKtp);
    }

    public function scopeEdit($query, string $noKtp, array $data) {
        $query->where('no_ktp', $noKtp)->update($data);
    }

    public function scopeRemove($query, string $noKtp) {
        $query->where('no_ktp', $noKtp)->delete();
    }

    public function scopeAllWithWos($query) : object {
        return $query->with('wos');
    }

    public function scopeOneWithWos($query, string $noKtp) : object {
        return $query->with('wos')->where('no_ktp', $noKtp);
    }

    public function wos() {
        return $this->hasMany('App\Models\Wos', 'no_ktp_penjahit', 'no_ktp');
    }
}
