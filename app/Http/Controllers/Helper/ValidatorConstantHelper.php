<?php

namespace App\Http\Controllers\Helper;

class ValidatorConstantHelper {

    public const RULES_JENIS_BAHAN = [
        'kode' => 'required|unique:jenis_bahan',
        'nama' => 'required',
        'warna' => 'required'
    ];
    public const RULES_JENIS_BAHAN2 = [
        'kode' => 'required',
        'nama' => 'required',
        'warna' => 'required'
    ];

    public const MESSAGE_JENIS_BAHAN = [
        'kode.required' => 'Kode tidak boleh kosong',
        'kode.unique' => 'Kode ini sudah digunakan',
        'nama.required' => 'Nama tidak boleh kosong',
        'warna.required' => 'Warna tidak boleh kosong'
    ];
    public const MESSAGE_JENIS_BAHAN2 = [
        'kode.required' => 'Kode tidak boleh kosong',
        'nama.required' => 'Nama tidak boleh kosong',
        'warna.required' => 'Warna tidak boleh kosong'
    ];

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
        'nama_produk' => 'required',
        'harga_jahit' => 'required|numeric',
        'hpp' => 'required|numeric'
    ];

    public const RULES_INDUK2 = [
        'kode' => 'required',
        'nama_produk' => 'required',
        'harga_jahit' => 'required|numeric',
        'hpp' => 'required|numeric'
    ];

    public const MESSAGES_INDUK = [
        'kode.required' => 'Kode tidak boleh kosong',
        'kode.unique' => 'Kode sudah terpakai, silahkan coba yang lain',
        'nama_produk.required' => 'Nama produk tidak boleh kosong',
        'harga_jahit.required' => 'Harga jahit tidak boleh kosong',
        'harga_jahit.numeric' => 'Harga jahit harus angka',
        'hpp.required' => 'HPP tidak boleh kosong',
        'hpp.numeric' => 'HPP harus berupa angka'
    ];

    public const MESSAGES_INDUK2 = [
        'kode.required' => 'Kode tidak boleh kosong',
        'nama_produk.required' => 'Nama produk tidak boleh kosong',
        'harga_jahit.required' => 'Harga jahit tidak boleh kosong',
        'harga_jahit.numeric' => 'Harga jahit harus angka',
        'hpp.required' => 'HPP tidak boleh kosong',
        'hpp.numeric' => 'HPP harus berupa angka'
    ];

    public const RULES_BARANG = [
        'kode' => 'required|unique:barang',
        'kode_induk' => 'required',
        'warna' => 'required',
        'stok' => 'required|numeric',
        'treshold' => 'required|numeric',
        'id_bahan' => 'required|numeric'
    ];

    public const MESSAGES_BARANG = [
        'kode.required' => 'Kode tidak boleh kosong',
        'kode.unique' => 'Kode sudah terpakai',
        'kode_induk.required' => 'Kode induk tidak boleh kosong',
        'warna.required' => 'Warna tidak boleh kosong',
        'stok.required' => 'Stok tidak boleh kosong',
        'stok.numeric' => 'Stok harus berupa angka',
        'treshold.required' => 'Treshold tidak boleh kosong',
        'treshold.numeric' => 'Treshold harus berupa angka',
        'id_bahan.required' => 'Id bahan tidak boleh kosong',
        'id_bahan.numeric' => 'Id bahan harus berupa angka'
    ];

    public const RULES_PENJAHIT = [
        'nomor_hp' => 'required|unique:penjahit',
        'nama_lengkap' => 'required',
        'alamat' => 'required'
    ];

    public const MESSAGES_PENJAHIT = [
        'nomor_hp.required' => 'Nomor hp tidak boleh kosong',
        'nomor_hp.unique' => 'Nomor hp sudah terpakai',
        'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
        'alamat.required' => 'Alamat tidak boleh kosong'
    ];

    public const RULES_PENJAHIT2 = [
        'nomor_hp' => 'required',
        'nama_lengkap' => 'required',
        'alamat' => 'required'
    ];

    public const MESSAGES_PENJAHIT2 = [
        'nomor_hp.required' => 'Nomor hp tidak boleh kosong',
        'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
        'alamat.required' => 'Alamat tidak boleh kosong'
    ];

}