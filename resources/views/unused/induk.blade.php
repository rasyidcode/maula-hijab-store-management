@extends('layouts.app')

@section('title', 'Data Induk')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Induk</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Data Induk</li>
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
                            <button type="button" class="btn btn-block btn-primary btn-sm">Tambah Induk</button>
                        </div>
    
                        <div class="card-tools">
                            <div class="row">
                                <div class="col-4">
                                    <div class="btn-group">
                                        <button id="refresh_induk" type="button" class="btn btn-default"><i class="fas fa-sync-alt"></i></button>
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
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Cari induk...">
                    
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
                        <table id="data_induk" class="table table-sm table-bordered table-hover text-nowrap text-center">
                            <thead>
                                <tr>
                                    <th width="1%">No.</th>
                                    <th width="10%">Kode Induk</th>
                                    <th>Nama Produk</th>
                                    <th>Harga Jahit</th>
                                    <th>HPP</th>
                                    <th>Created At</th>
                                    <th>Action</th>
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
                                    <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
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

<div class="modal fade" id="modal_induk_detail">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Induk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul id="list-detail" class="list-group list-group-bordered"></ul>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
<script src="{{ asset('js/models/model_induk.js') }}"></script>
<script src="{{ asset('js/induk.js') }}"></script>
@endsection