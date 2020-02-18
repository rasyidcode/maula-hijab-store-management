<?php

namespace App\Http\Controllers\Helper;

class ValidatorHelper {

    public static function rulesBahan(bool $isCreate) : array {
        return [
            'kode' => $isCreate ? 'required|unique:jenis_bahan' : 'required',
            'nama' => 'required',
            'warna' => 'required'
        ];
    }

    public static function messagesBahan(bool $isCreate) : array {
        return $isCreate ? [
            'kode.required' => 'Kode tidak boleh kosong',
            'kode.unique' => 'Kode ini sudah digunakan',
            'nama.required' => 'Nama tidak boleh kosong',
            'warna.required' => 'Warna tidak boleh kosong'
        ] : [
            'kode.required' => 'Kode tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'warna.required' => 'Warna tidak boleh kosong'
        ];
    }

    public const RULES_BAHAN = [
        'kode_jenis_bahan' => 'required',
        'harga' => 'required|numeric',
        'yard' => 'required|numeric',
        'tanggal_masuk' => 'required'
    ];
    public const MESSAGES_BAHAN = [
        'kode_jenis_bahan.required' => 'Kode jenis bahan tidak boleh kosong',
        'harga.required' => 'Harga tidak boleh kosong',
        'harga.numeric' => 'Harga harus berupa angka',
        'yard.required' => 'Yard tidak boleh kosong',
        'yard.numeric' => 'Yard harus berupa angka',
        'tanggal_masuk.required' => 'Tanggal masuk tidak boleh kosong'
    ];

    public const RULES_INDUK = [
        'kode' => 'required|unique:induk',
        'harga_jahit' => 'required|numeric',
        'harga_basic' => 'required|numeric',
        'hpp_shopee' => 'required|numeric',
        'hpp_lazada' => 'required|numeric',
        'dfs_shopee' => 'required|numeric',
        'dfs_lazada' => 'required|numeric'
    ];
    public const RULES_INDUK2 = [
        'kode' => 'required',
        'harga_jahit' => 'required|numeric',
        'harga_basic' => 'required|numeric',
        'hpp_shopee' => 'required|numeric',
        'hpp_lazada' => 'required|numeric',
        'dfs_shopee' => 'required|numeric',
        'dfs_lazada' => 'required|numeric'
    ];
    public const MESSAGES_INDUK = [
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
    public const MESSAGES_INDUK2 = [
        'kode.required' => 'Kode tidak boleh kosong',
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

    public const RULES_BARANG = [
        'kode' => 'required|unique:barang',
        'kode_induk' => 'required',
        'warna' => 'required',
        'stok_ready' => 'required|numeric',
        'treshold' => 'required|numeric'
    ];
    public const RULES_BARANG2 = [
        'kode' => 'required',
        'kode_induk' => 'required',
        'warna' => 'required',
        'stok_ready' => 'required|numeric',
        'treshold' => 'required|numeric'
    ];
    public const MESSAGES_BARANG = [
        'kode.required' => 'Kode tidak boleh kosong',
        'kode.unique' => 'Kode sudah terpakai',
        'kode_induk.required' => 'Kode induk tidak boleh kosong',
        'warna.required' => 'Warna tidak boleh kosong',
        'stok_ready.required' => 'Stok tidak boleh kosong',
        'stok_ready.numeric' => 'Stok harus berupa angka',
        'treshold.required' => 'Treshold tidak boleh kosong',
        'treshold.numeric' => 'Treshold harus berupa angka'
    ];
    public const MESSAGES_BARANG2 = [
        'kode.required' => 'Kode tidak boleh kosong',
        'kode_induk.required' => 'Kode induk tidak boleh kosong',
        'warna.required' => 'Warna tidak boleh kosong',
        'stok_ready.required' => 'Stok tidak boleh kosong',
        'stok_ready.numeric' => 'Stok harus berupa angka',
        'treshold.required' => 'Treshold tidak boleh kosong',
        'treshold.numeric' => 'Treshold harus berupa angka'
    ];

    public const RULES_PENJAHIT = [
        'no_ktp' => 'required|unique:penjahit',
        'nama_lengkap' => 'required',
        'no_hp' => 'required',
        'alamat' => 'required',
    ];
    public const MESSAGES_PENJAHIT = [
        'no_ktp.required' => 'Nomor ktp tidak boleh kosong',
        'no_ktp.unique' => 'Nomor ktp sudah terpakai',
        'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
        'no_hp.required' => 'Nomor hp tidak boleh kosong',
        'alamat.required' => 'Alamat tidak boleh kosong'
    ];
    public const RULES_PENJAHIT2 = [
        'no_ktp' => 'required',
        'nama_lengkap' => 'required',
        'no_hp' => 'required',
        'alamat' => 'required',
    ];
    public const MESSAGES_PENJAHIT2 = [
        'no_ktp.required' => 'Nomor ktp tidak boleh kosong',
        'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
        'no_hp.required' => 'Nomor hp tidak boleh kosong',
        'alamat.required' => 'Alamat tidak boleh kosong'
    ];

    public const RULES_WOS = [
        'kode_barang' => 'required',
        'id_bahan' => 'required',
        'yard' => 'required|numeric',
        'pcs' => 'required|numeric'
    ];
    public const MESSAGES_WOS = [
        'kode_barang.required' => 'Kode barang tidak boleh kosong!',
        'id_bahan.required' => 'Id bahan tidak boleh kosong!',
        'yard.required' => 'Yard tidak boleh kosong!',
        'yard.numeric' => 'Yard harus berupa angka!',
        'pcs.required' => 'Pcs tidak boleh kosong!',
        'pcs.numeric' => 'Pcs harus berupa angka!'
    ];

}