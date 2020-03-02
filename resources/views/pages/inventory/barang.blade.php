@extends('layouts.app')

@section('title', 'List Barang')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Barang</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Barang</li>
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
                        <h3 class="card-title">List Barang</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- <th>Stok OnProgress</th> jumlah wos yang masih belum dikembalikan -->
                        <table id="list_barang" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Kode Kain</th>
                                    <th>Kode Induk</th>
                                    <th>Stok Ready</th>
                                    <th>Stok On Progress</th>
                                    <th>Treshold</th>
                                    <th>Status Produksi</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-primary btn-sm" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_create_barang"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Modal show barang -->
{{-- <div class="modal fade" id="modal_show_barang">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail bahan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">Kode</dt>
                        <dd id="dt_kode" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Kode Induk</dt>
                        <dd id="dt_kode_induk" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Warna</dt>
                        <dd id="dt_warna" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Stok Ready</dt>
                        <dd id="dt_stok_ready" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Treshold</dt>
                        <dd id="dt_treshold" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Tanggal dibuat</dt>
                        <dd id="dt_created_at" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Tanggal diupdate</dt>
                        <dd id="dt_updated_at" class="col-sm-8"></dd>
                </dl>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}

<!-- Modal create barang -->
<div class="modal fade" id="modal_create_barang">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_create_barang" role="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="kode_induk">Kode Induk</label>
                                <select id="kode_induk" class="form-control" style="width: 100%;">
                                    <option value="0">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nama_kain">Nama Kain</label>
                                <select id="nama_kain" class="form-control" style="width: 100%;">
                                    <option value="0">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div style="display: none;" class="col-12">
                            <div class="form-group">
                                <label for="warna_kain">Warna Kain</label>
                                <select id="warna_kain" class="form-control" style="width: 100%;">
                                    <option value="0">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="stok_ready">Stok Ready</label>
                                <input id="stok_ready" type="number" class="form-control" placeholder="Ex : 100" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="treshold">Treshold</label>
                                <input id="treshold" type="number" class="form-control" placeholder="Ex : 100" required>
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

<!-- Modal edit barang -->
<div class="modal fade" id="modal_edit_barang">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_barang" role="form">
                <input id="kodes" type="hidden" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="kode_induk2">Kode Induk</label>
                                <select id="kode_induk2" class="form-control" style="width: 100%;">
                                    <option value="0">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nama_kain2">Nama Kain</label>
                                <select id="nama_kain2" class="form-control" style="width: 100%;">
                                    <option value="0">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div style="display: none;" class="col-12">
                            <div class="form-group">
                                <label for="warna_kain2">Warna Kain</label>
                                <select id="warna_kain2" class="form-control" style="width: 100%;">
                                    <option value="0">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="stok_ready2">Stok Ready</label>
                                <input id="stok_ready2" type="number" class="form-control" placeholder="Ex : 100" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="treshold2">Treshold</label>
                                <input id="treshold2" type="number" class="form-control" placeholder="Ex : 100" required>
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

@section('custom-js')
<script src="{{ asset('js/models/model_barang.js') }}"></script>
<script src="{{ asset('js/inventory/barang.js') }}"></script>
<script>
$(function() {
    $('#kode_induk').select2({ theme: 'bootstrap4' })
    $('#nama_kain').select2({ theme: 'bootstrap4' })
    $('#warna_kain').select2({ theme: 'bootstrap4' })

    $('#kode_induk2').select2({ theme: 'bootstrap4' })
    $('#nama_kain2').select2({ theme: 'bootstrap4' })
    $('#warna_kain2').select2({ theme: 'bootstrap4' })
})
</script>
@endsection