<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class GeneralHelper {

    public static function validator($data, $rules, $messages) : Validator {
        return Validator::make($data, $rules, $messages);
    }

}