<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trash extends Model {
    
    protected $table = 'trash';
    protected $guarded = [];
    
    public function scopeUpdate($query, int $id, array $data) : object {
        return $query->where('id', $id)->update($data);
    }

    public function scopeDelete($query, int $id) {
        $query->find($id)->delete();
    }
}
