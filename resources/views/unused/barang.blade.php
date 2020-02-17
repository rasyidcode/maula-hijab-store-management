@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Barang</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Barang</li>
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
                        <div class="card-title">
                            <button type="button" class="btn btn-block btn-primary btn-sm p-2">
                                <i class="fas fa-plus mr-2"></i> Tambah Barang
                            </button>
                        </div>
    
                        <div class="card-tools">
                            <div class="row">
                                <div class="col-4">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default"><i class="fas fa-sync-alt"></i></button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">10</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">10</a>
                                                <a class="dropdown-item" href="#">50</a>
                                                <a class="dropdown-item" href="#">100</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="input-group input-group-sm p-2">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Cari barang...">
                    
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table id="data_barang" class="table table-sm table-bordered table-hover text-nowrap text-center">
                            <thead>
                                <tr>
                                    <th width="1%">No.</th>
                                    <th width="5%">Kode</th>
                                    <th width="25%">Nama Produk</th>
                                    <th width="5%">Warna</th>
                                    <th width="5%">Bahan</th>
                                    <th width="5%">Stok</th>
                                    <th width="10%">Treshold</th> <!-- green +50, orange +20 red +0 -->
                                    <th>Total Modal</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <div class="row">
                            <div class="col-8">
                                <ul class="pagination pagination-sm m-0">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div>
                            <div class="col-4 text-right">
                                <p>Data dari <strong>1</strong> s/d <strong>10</strong> dari <strong>1000</strong></p>
                            </div>
                        </div>
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

@section('custom-css-adminlte')
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('custom-js-adminlte')
<!-- SweetAlert2 -->
<script src="{{ asset('admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection

@section('custom-css')
@endsection

@section('custom-js')
<script src="{{ asset('js/general.js') }}"></script>
<script src="{{ asset('js/models/model_barang.js') }}"></script>
<script src="{{ asset('js/barang.js') }}"></script>
@endsection