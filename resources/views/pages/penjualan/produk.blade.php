@extends('layouts.app')

@section('title', 'List Pembayaran')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Produk</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Produk</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="list_produk" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>I</th>
                                    <th>No. Pemesanan</th>
                                    <th>SKU Induk</th>
                                    <th>Nama Produk</th>
                                    <th>No Referensi SKU</th>
                                    <th>Warna</th>
                                    <th>Harga Asli</th>
                                    <th>Jumlah Pesanan</th>
                                    <th>Total Harga Produk</th>
                                    <th>Total Diskon</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('custom-js')
<script src="{{ asset('js/penjualan/produk.js') }}"></script>
@endsection