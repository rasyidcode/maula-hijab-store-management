<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoggerCrud extends Model {
    protected $table = 'logger_crud';
    protected $guarded = [];

    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const GET = 'get';
    public const DELETE = 'delete';

    public function scopeGetByDate($query, string $date) {
        return $query->where('log_date', $date);
    }

    public function scopeUpdate($query, int $id, array $data) {
        return $query->where('id', $id)->update($data);
    }

    public function scopeDelete($query, int $id) {
        return $query->find($id)->delete();
    }
}
