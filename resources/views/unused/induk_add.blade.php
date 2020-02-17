@extends('layouts.app')

@section('title')
    Dashboard - Tambah Induk
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Induk</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Data Induk</a></li>
                    <li class="breadcrumb-item active">Tambah Induk</li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Induk</h3>
                    </div>
                    <form id="form_create_induk" role="form">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kode">Kode</label>
                                <input id="kode" type="text" class="form-control" placeholder="Ex : TPDL">
                            </div>
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input id="nama_produk" type="text" class="form-control" placeholder="Ex : TPDL">
                            </div>
                            <div class="form-group">
                                <label for="harga_jahit">Harga Jahit</label>
                                <input id="harga_jahit" type="text" class="form-control" placeholder="Ex : Rp. 12.000">
                            </div>
                            <div class="form-group">
                                <label for="hpp">HPP</label>
                                <input id="hpp" type="text" class="form-control" placeholder="Ex : Rp. 13.500">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('custom-css-adminlte')
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('custom-js-adminlte')
<!-- SweetAlert2 -->
<script src="{{ asset('admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection

@section('custom-js')
<script src="{{ asset('js/general.js') }}"></script>
<script src="{{ asset('js/induk.js') }}"></script>
@endsection