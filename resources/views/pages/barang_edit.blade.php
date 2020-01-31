@extends('layouts.app')

@section('title')
    Dashboard - Edit Barang
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Barang</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Data Induk</a></li>
                    <li class="breadcrumb-item active">Edit Barang</li>
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
                        <h3 class="card-title">Form Edit Barang</h3>
                    </div>
                    <form id="form_edit_barang" role="form">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kode">Kode</label>
                                <input id="kode" type="text" class="form-control" placeholder="Ex : TPDL-Merah">
                            </div>
                            <div class="form-group">
                                <label for="select_induk_list">Pilih Induk</label>
                                <select id="select_induk_list" class="form-control custom-select">
                                    <option value="" disabled>Pilih Satu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="warna">Warna</label>
                                <input id="warna" type="text" class="form-control" placeholder="Ex : Merah">
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input id="stok" type="number" class="form-control" placeholder="Ex : 50">
                            </div>
                            <div class="form-group">
                                <label for="treshold">Treshold</label>
                                <input id="treshold" type="number" class="form-control" placeholder="Ex : 10">
                            </div>
                            <div class="form-group">
                                <label for="select_bahan_list">Pilih Bahan</label>
                                <select id="select_bahan_list" class="form-control custom-select">
                                    <option value="" disabled>Pilih Satu</option>
                                </select>
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
<script src="{{ asset('js/models/model_induk.js') }}"></script>
<script src="{{ asset('js/models/model_bahan.js') }}"></script>
<script src="{{ asset('js/models/model_barang.js') }}"></script>
<script src="{{ asset('js/barang.js') }}"></script>
@endsection