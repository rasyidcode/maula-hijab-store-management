<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBahan extends Model
{
    protected $table = 'jenis_bahan';
    protected $primaryKey = 'kode';
    public $incrementing = false;

    protected $guarded = [];

    /* START OF SCOPE */
    public function scopeGetOne($query, string $kode) {
        return $query->where('kode', $kode);
    }

    public function scopeEdit($query, string $kode, array $data) {
        $query->where('kode', $kode)->update($data);
    }

    public function scopeRemove($query, string $kode) {
        $query->where('kode', $kode)->delete();
    }

    public function scopeGetWithBahan($query, string $kode) {
        return $query->with('bahan')->where('kode', $kode);
    }

    public function scopeGetAllWithBahan($query) {
        return $query->with('bahan');
    }
    /* END OF SCOPE */

    public function bahan() {
        return $this->hasMany(Bahan::class, 'kode_jenis_bahan', 'kode');
    }
}
