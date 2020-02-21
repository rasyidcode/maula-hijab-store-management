<?php

namespace App\Http\Controllers\Helper;

class ValidatorHelper {

    public static function rulesJenisBahan(bool $isCreate) : array {
        return [
            'kode' => $isCreate ? 'required|unique:jenis_bahan' : 'required',
            'nama' => 'required',
            'warna' => 'required'
        ];
    }

    public static function messagesJenisBahan() : array {
        return [
            'kode.required' => 'Kode tidak boleh kosong',
            'kode.unique' => 'Kode ini sudah digunakan',
            'nama.required' => 'Nama tidak boleh kosong',
            'warna.required' => 'Warna tidak boleh kosong'
        ];
    }

    public static function rulesBahan() : array {
        return [
            'kode_jenis_bahan' => 'required',
            'harga' => 'required|numeric',
            'yard' => 'required|numeric',
            'tanggal_masuk' => 'required'
        ];
    }

    public static function messagesBahan() : array {
        return [
            'kode_jenis_bahan.required' => 'Kode jenis bahan tidak boleh kosong',
            'harga.required' => 'Harga tidak boleh kosong',
            'harga.numeric' => 'Harga harus berupa angka',
            'yard.required' => 'Yard tidak boleh kosong',
            'yard.numeric' => 'Yard harus berupa angka',
            'tanggal_masuk.required' => 'Tanggal masuk tidak boleh kosong'
        ];
    }

    public static function rulesInduk(bool $isCreate) : array {
        return [
            'kode' => $isCreate ? 'required|unique:induk' : 'required',
            'harga_jahit' => 'required|numeric',
            'harga_basic' => 'required|numeric',
            'hpp_shopee' => 'required|numeric',
            'hpp_lazada' => 'required|numeric',
            'dfs_shopee' => 'required|numeric',
            'dfs_lazada' => 'required|numeric'
        ];
    }

    public static function messagesInduk() : array {
        return [
            'kode.required' => 'Kode tidak boleh kosong',
            'kode.unique' => 'Kode sudah terpakai, silahkan coba yang lain',
            'harga_jahit.required' => 'Harga jahit tidak boleh kosong',
            'harga_jahit.numeric' => 'Harga jahit harus angka',
            'harga_basic.required' => 'Harga basic tidak boleh kosong',
            'harga_basic.numeric' => 'Harga basic harus angka',
            'hpp_shopee.required' => 'Hpp shopee tidak boleh kosong',
            'hpp_shopee.numeric' => 'Hpp shopee harus angka',
            'hpp_lazada.required' => 'Hpp lazada tidak boleh kosong',
            'hpp_lazada.numeric' => 'Hpp lazadaharus angka',
            'dfs_shopee.required' => 'Dfs shopee tidak boleh kosong',
            'dfs_shopee.numeric' => 'Dfs shopee harus angka',
            'dfs_lazada.required' => 'Dfs lazada tidak boleh kosong',
            'dfs_lazada.numeric' => 'Dfs lazada harus angka'
        ];
    }

    public static function rulesBarang(bool $isCreate) : array {
        return [
            'kode' => $isCreate ? 'required|unique:barang' : 'required',
            'kode_induk' => 'required',
            'warna' => 'required',
            'stok_ready' => 'required|numeric',
            'treshold' => 'required|numeric'
        ];
    }

    public static function messagesBarang() : array {
        return [
            'kode.required' => 'Kode tidak boleh kosong',
            'kode.unique' => 'Kode sudah terpakai',
            'kode_induk.required' => 'Kode induk tidak boleh kosong',
            'warna.required' => 'Warna tidak boleh kosong',
            'stok_ready.required' => 'Stok tidak boleh kosong',
            'stok_ready.numeric' => 'Stok harus berupa angka',
            'treshold.required' => 'Treshold tidak boleh kosong',
            'treshold.numeric' => 'Treshold harus berupa angka'
        ];
    }

    public static function rulesPenjahit(bool $isCreate) : array {
        return [
            'no_ktp' => $isCreate ? 'required|unique:penjahit' : 'required',
            'nama_lengkap' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ];
    }

    public static function messagesPenjahit() : array {
        return [
            'no_ktp.required' => 'Nomor ktp tidak boleh kosong',
            'no_ktp.unique' => 'Nomor ktp sudah terpakai',
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'no_hp.required' => 'Nomor hp tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong'
        ];
    }

    public static function rulesWos() : array {
        return [
            'kode_barang' => 'required',
            'id_bahan' => 'required',
            'yard' => 'required|numeric',
            'pcs' => 'required|numeric'
        ];
    }

    public static function messagesWos() : array {
        return [
            'kode_barang.required' => 'Kode barang tidak boleh kosong!',
            'id_bahan.required' => 'Id bahan tidak boleh kosong!',
            'yard.required' => 'Yard tidak boleh kosong!',
            'yard.numeric' => 'Yard harus berupa angka!',
            'pcs.required' => 'Pcs tidak boleh kosong!',
            'pcs.numeric' => 'Pcs harus berupa angka!'
        ];
    }

}