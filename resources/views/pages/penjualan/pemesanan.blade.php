@extends('layouts.app')

@section('title', 'List Pembayaran')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Pemesanan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Pemesanan</li>
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
                    <div class="card-header">
                        <button id="button_create_pemesanan" type="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-3"></i>Tambah Pemesanan
                        </button>
                        <button id="button_export_data" type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-plus mr-3"></i>Export Data
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="list_pemesanan" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Metode Input</td>
                                    <th>No. Pemesanan</th>
                                    <th>No. Resi</th>
                                    <th>Kurir</th>
                                    <th>Total Pembayaran</th>
                                    <th>Alamat Pengiriman</th>
                                    <th>Nomor HP</th>
                                    <th>Produk yang dipesan</th>
                                    <th>Action</th>
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
<script src="{{ asset('js/penjualan/pemesanan.js') }}"></script>
@endsection