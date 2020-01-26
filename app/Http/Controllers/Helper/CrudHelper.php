<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Database\Eloquent\Model;

class CrudHelper {

    public static function get_all(string $model) : object {
        if (CrudHelper::checkClass($model)) {
            return $model::all();
        } else {
            return (object)[];
        }
    }

    public static function get(string $model, int $id) : object {
        if (CrudHelper::checkClass($model)) {
            return $model::findOrFail($id);
        } else {
            return (object)[];
        }
    }

    public static function create(string $model, array $data) : object {
        if (CrudHelper::checkClass($model)) {
            return $model::create($data);
        } else {
            return (object)[];
        }
    }

    public static function update(string $model, int $id, array $data) : object {
        if (CrudHelper::checkClass($model)) {
            $model::whereId($id)->update($data);
            return CrudHelper::get($model, $id);
        } else {
            return (object)[];
        }
    }

    public static function delete(string $model, int $id) : object {
        if (CrudHelper::checkClass($model)) {
            $model::destroy($id);
            return (object)[];
        } else {
            return (object)[];
        }
    }

    private static function checkClass(string $model) : bool {
        $test = new $model;
        return $test instanceof Model;
    }

}