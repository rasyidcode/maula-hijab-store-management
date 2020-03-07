<?php

namespace App\Http\Controllers\Helper;

class ValidatorHelper {

    public static function rulesWarna(bool $isCreate = true) : array {
        return [
            'name' => $isCreate ? 'required|string|unique:warna' : 'required|string',
            'hex_code' => 'string'
        ];
    }

    public static function messageWarna(bool $isCreate = true) : array {
        return $isCreate ? 
            [
                'name.required' => 'Nama tidak boleh kosong!',
                'name.string' => 'Nama harus berupa string!',
                'name.unique' => 'Warna sudah ada, coba yang lain!',
                'hex_code.string' => 'Hex code harus berupa string!',
            ]
            :
            [
                'name.required' => 'Nama tidak boleh kosong!',
                'name.string' => 'Nama harus berupa string!',
                'hex_code.string' => 'Hex code harus berupa string!'
            ];
    }

    public static function rulesBahan(bool $isCreate = true) : array {
        return [
                'nama' => $isCreate ? 'required|string|unique:bahan' : 'required|string',
                'deskripsi' => 'string'
            ];
    }

    public static function messageBahan(bool $isCreate = true) : array {
        return $isCreate ?
            [
                'nama.required' => 'Nama tidak boleh kosong!',
                'nama.string' => 'Nama harus berupa string!',
                'nama.unique' => 'Nama sudah digunakan!',
                'deskripsi.string' => 'Deskripsi harus berupa string'
            ] : [
                'nama.required' => 'Nama tidak boleh kosong!',
                'nama.string' => 'Nama harus berupa string!',
                'deskripsi.string' => 'Deskripsi harus berupa string'
            ];
    }

    public static function rulesKain(bool $isCreate) : array {
        return [
            'kode' => $isCreate ? 'required|unique:kain' : 'required',
            'nama' => 'required',
            'warna' => 'required'
        ];
    }

    public static function messagesKain() : array {
        return [
            'kode.required' => 'Kode tidak boleh kosong',
            'kode.unique' => 'Kode ini sudah digunakan',
            'nama.required' => 'Nama tidak boleh kosong',
            'warna.required' => 'Warna tidak boleh kosong'
        ];
    }

    public static function rulesTransaksiKain() : array {
        return [
            'kode_kain' => 'required',
            'harga' => 'required|numeric',
            'yard' => 'required|numeric',
            'tanggal_masuk' => 'required'
        ];
    }

    public static function messagesTransaksiKain() : array {
        return [
            'kode_kain.required' => 'Kode jenis bahan tidak boleh kosong',
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
            'kode_kain' => 'required',
            'stok_ready' => 'required',
            'treshold' => 'required|numeric'
        ];
    }

    public static function messagesBarang() : array {
        return [
            'kode.required' => 'Kode tidak boleh kosong',
            'kode.unique' => 'Kode sudah terpakai',
            'kode_induk.required' => 'Kode induk tidak boleh kosong',
            'kode_kain.required' => 'Kode kain tidak boleh kosong',
            'stok_ready.required' => 'Stok ready tidak boleh kosong',
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
            'id_transaksi_kain' => 'required',
            'pcs' => 'required|numeric'
        ];
    }

    public static function messagesWos() : array {
        return [
            'kode_barang.required' => 'Kode barang tidak boleh kosong!',
            'id_transaksi_kain.required' => 'Id bahan tidak boleh kosong!',
            'pcs.required' => 'Pcs tidak boleh kosong!',
            'pcs.numeric' => 'Pcs harus berupa angka!'
        ];
    }

}