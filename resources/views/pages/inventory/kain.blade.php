@extends('layouts.app')

@section('title', 'List Kain')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Kain</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Kain</li>
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
                        <h3 class="card-title">List Kain</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="list_kain" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode Kain</th>
                                    <th>Nama</th>
                                    <th>Warna</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <!-- {{-- <tfoot>
                                <tr>
                                    <th>Kode Kain</th>
                                    <th>Nama</th>
                                    <th>Warna</th>
                                    <th>Created At</th>
                                </tr>
                            </tfoot> --}} -->
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_create_kain"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<div class="modal fade" id="modal_create_kain">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah kain</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_create_kain" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input id="nama" type="text" class="form-control" placeholder="Ex : Diamond" required>
                    </div>
                    <div class="form-group">
                        <label for="warna">Warna</label>
                        <input id="warna" type="text" class="form-control" placeholder="Ex : Merah" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- <div class="modal fade" id="modal_show_jenis_bahan">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail jenis bahan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">Kode</dt>
                        <dd id="dt_kode" class="col-sm-8">Test</dd>
                    <dt class="col-sm-4">Nama</dt>
                        <dd id="dt_nama" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Warna</dt>
                        <dd id="dt_warna" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Tanggal dibuat</dt>
                        <dd id="dt_created_at" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Tanggal diupdate</dt>
                        <dd id="dt_updated_at" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Jumlah digunakan</dt>
                        <dd id="dt_used_count" class="col-sm-8"></dd>
                </dl>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->

<div class="modal fade" id="modal_edit_kain">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit kain</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_kain" role="form">
                <div class="modal-body">
                    <input id="kode2" type="hidden" type="text">
                    <div class="form-group">
                        <label for="nama2">Nama</label>
                        <input id="nama2" type="text" class="form-control" placeholder="Ex : Diamond" required>
                    </div>
                    <div class="form-group">
                        <label for="warna2">Warna</label>
                        <input id="warna2" type="text" class="form-control" placeholder="Ex : Merah" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@section('custom-js')
<script src="{{ asset('js/models/model_kain.js') }}"></script>
<script src="{{ asset('js/inventory/kain.js') }}"></script>
@endsection