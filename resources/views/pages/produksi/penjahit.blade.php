@extends('layouts.app')

@section('title', 'List Penjahit')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Penjahit</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Penjahit</li>
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
                        <h3 class="card-title">List Penjahit</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="list_penjahit" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. KTP</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nomor HP</th>
                                    <th>Alamat</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_create_penjahit"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<div class="modal fade" id="modal_create_penjahit">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Penjahit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_create_penjahit" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_ktp">No. KTP</label>
                        <input id="no_ktp" type="text" class="form-control" placeholder="Ex : 113330011100" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input id="nama_lengkap" type="text" class="form-control" placeholder="Ex : Ahmad Jamil Al Rasyid" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <input id="no_hp" type="text" class="form-control" placeholder="Ex : 081226836303" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" cols="30" rows="10" placeholder="Ex : Jln. Rasamala No. 10C, Condongcatur, Yogyakarta" required></textarea>
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

<div class="modal fade" id="modal_show_penjahit">
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
                    <dt class="col-sm-4">No. KTP</dt>
                        <dd id="dt_no_ktp" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Nama Lengkap</dt>
                        <dd id="dt_nama_lengkap" class="col-sm-8"></dd>
                    <dt class="col-sm-4">No. HP</dt>
                        <dd id="dt_no_hp" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Alamat</dt>
                        <dd id="dt_alamat" class="col-sm-8"></dd>
                    <dt class="col-sm-4">Tanggal dibuat</dt>
                        <dd id="dt_created_at" class="col-sm-8"></dd> <!-- Rabu, 14 April 2019, 06:05 AM -->
                    <dt class="col-sm-4">Tanggal diupdate</dt>
                        <dd id="dt_updated_at" class="col-sm-8"></dd> <!-- Rabu, 15 April 2019, 06:05 AM -->
                </dl>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_jenis_bahan">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit jenis bahan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_jenis_bahan" role="form">
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
<script src="{{ asset('js/models/model_penjahit.js') }}"></script>
<script src="{{ asset('js/produksi/penjahit.js') }}"></script>
@endsection