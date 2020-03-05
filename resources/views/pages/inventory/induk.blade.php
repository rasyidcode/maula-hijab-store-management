@extends('layouts.app')

@section('title', 'List Induk')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Induk</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Induk</li>
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
                <!-- TODO: bikin daterangepicker berdasarkan tanggal_masuk, created_at, updated_at -->
                <!-- TODO: bikin moneyrangepicker berdasarkan harga -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_create_induk">
                            <i class="fas fa-plus mr-3"></i>Tambah
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="list_induk" class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th>id</th> -->
                                    <th>Kode</th>
                                    <th>Harga Jahit</th>
                                    <th>Harga basic</th>
                                    <th>Created At</th>
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

<!-- Modal create induk -->
<div class="modal fade" id="modal_create_induk">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah induk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_create_induk" role="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="kode">Kode</label>
                                <input id="kode" type="text" class="form-control" placeholder="Ex : TPDL" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="harga_jahit">Harga Jahit</label>
                                <input id="harga_jahit" type="text" class="form-control" placeholder="Ex : Rp. 30.000" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="harga_basic">Harga Basic</label>
                                <input id="harga_basic" type="text" class="form-control" placeholder="Ex : Rp. 12.000" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="hpp_shopee">HPP Shopee</label>
                                <input id="hpp_shopee" type="text" class="form-control" placeholder="Ex : Rp. 20.000" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dfs_shopee">DFS Shopee</label>
                                <input id="dfs_shopee" type="text" class="form-control" placeholder="Ex : Rp. 17.000" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="hpp_lazada">HPP Lazada</label>
                                <input id="hpp_lazada" type="text" class="form-control" placeholder="Ex : Rp. 31.000" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dfs_lazada">DFS Lazada</label>
                                <input id="dfs_lazada" type="text" class="form-control" placeholder="Ex : Rp. 21.000" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit bahan -->
<div class="modal fade" id="modal_edit_induk">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit induk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_induk" role="form">
                <div class="modal-body">
                    <div class="row">
                        <input id="kodes2" type="hidden">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="kode2">Kode</label>
                                <input id="kode2" type="text" class="form-control" placeholder="Ex : TPDL" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="harga_jahit2">Harga Jahit</label>
                                <input id="harga_jahit2" type="text" class="form-control" placeholder="Ex : Rp. 30.000" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="harga_basic2">Harga Basic</label>
                                <input id="harga_basic2" type="text" class="form-control" placeholder="Ex : Rp. 12.000" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="hpp_shopee2">HPP Shopee</label>
                                <input id="hpp_shopee2" type="text" class="form-control" placeholder="Ex : Rp. 20.000" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dfs_shopee2">DFS Shopee</label>
                                <input id="dfs_shopee2" type="text" class="form-control" placeholder="Ex : Rp. 17.000" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="hpp_lazada2">HPP Lazada</label>
                                <input id="hpp_lazada2" type="text" class="form-control" placeholder="Ex : Rp. 31.000" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dfs_lazada2">DFS Lazada</label>
                                <input id="dfs_lazada2" type="text" class="form-control" placeholder="Ex : Rp. 21.000" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-css')
@endsection

@section('custom-js')
<script src="{{ asset('js/models/model_induk.js') }}"></script>
<script src="{{ asset('js/inventory/induk.js') }}"></script>
<script>
$(function() {
    $('#harga_jahit').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#harga_basic').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#hpp_shopee').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#dfs_shopee').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#hpp_lazada').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#dfs_lazada').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })

    $('#harga_jahit2').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#harga_basic2').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#hpp_shopee2').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#dfs_shopee2').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#hpp_lazada2').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#dfs_lazada2').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
})
</script>
@endsection