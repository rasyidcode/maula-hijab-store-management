<?php

namespace App\Http\Controllers\Helper;

class TempProduct {

    public $productName;
    public $color;
    public $harga;
    public $quantity;
    public $noRefSKU;
    public $skuInduk;

    // public function __construct(
    //     string $productName,
    //     string $color,
    //     int $harga,
    //     int $quantity,
    //     string $noRefSKU,
    //     string $skuInduk
    // ) {
    //     $this->productName = $productName;
    //     $this->color = $color;
    //     $this->harga = $harga;
    //     $this->quantity = $quantity;
    //     $this->noRefSKU = $noRefSKU;
    //     $this->skuInduk = $skuInduk;
    // }

    public function __toString() {
        return "Nama Produk : {$productName}";
    }
}