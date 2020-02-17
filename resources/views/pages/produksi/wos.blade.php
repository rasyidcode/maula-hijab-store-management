@extends('layouts.app')

@section('title', 'List Work Order Sheet')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Work Order Sheet</h1>
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
                        <h3 class="card-title">List Work Order Sheet</h3>
                        <button id="btn_add_wos" type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="list_wos" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Created At</th>
                                    <th>Nama Penjahit</th>
                                    <th>Kode Barang</th>
                                    <th>Yard</th>
                                    <th>Pcs</th>
                                    <th>Demand</th>
                                    <th>Tanggal Ambil</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Jumlah Kembali</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- modal form create wos -->
<div class="modal fade" id="modal_create_wos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Wos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_create_wos" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_barang">Pilih Barang</label>
                        <select id="kode_barang" class="form-control" style="width: 100%;">
                            <option value="0">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_bahan">Nama Bahan</label>
                        <select id="nama_bahan" class="form-control" style="width: 100%;">
                            <option value="0">Pilih</option>
                        </select>
                    </div>
                    <div style="display: none;" class="form-group">
                        <label for="warna_bahan">Warna Bahan</label>
                        <select id="warna_bahan" class="form-control" style="width: 100%;">
                            <option value="0">Pilih</option>
                        </select>
                    </div>
                    <div style="display: none;" class="form-group">
                        <label for="yard_bahan">Yard</label>
                        <select id="yard_bahan" class="form-control" style="width: 100%;">
                            <option value="0">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pcs">Pcs</label>
                        <input id="pcs" type="number" class="form-control" placeholder="Ex : 20" required>
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

<!-- modal form take wos -->
<div class="modal fade" id="modal_take_wos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ambil Jahitan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_take_wos" role="form">
                <div class="modal-body">
                    <input id="id_wos_taked" type="hidden">
                    <div class="form-group">
                        <label for="no_ktp">Pilih Penjahit</label>
                        <select id="no_ktp" class="form-control" style="width: 100%;">
                            <option value="0">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Ambil</label>
                        <div class="input-group date" id="tanggal_ambil_picker" data-target-input="nearest">
                            <input id="tanggal_ambil" type="text" class="form-control datetimepicker-input" data-target="#tanggal_ambil_picker"/>
                            <div class="input-group-append" data-target="#tanggal_ambil_picker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-calendar"></i></div>
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

<!-- modal form return wos -->
<div class="modal fade" id="modal_return_wos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ambil Jahitan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_return_wos" role="form">
                <div class="modal-body">
                    <input id="id_wos_returned" type="hidden">
                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <div class="input-group date" id="tanggal_kembali_picker" data-target-input="nearest">
                            <input id="tanggal_kembali" type="text" class="form-control datetimepicker-input" data-target="#tanggal_kembali_picker"/>
                            <div class="input-group-append" data-target="#tanggal_kembali_picker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_kembali">Jumlah kembali</label>
                        <input id="jumlah_kembali" type="number" class="form-control" placeholder="Ex : 20" required>
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
<script src="{{ asset('js/models/model_wos.js') }}"></script>
<script src="{{ asset('js/produksi/wos.js') }}"></script>
<script>
$(function() {
    $('#kode_barang').select2({ theme: 'bootstrap4' })
    $('#nama_bahan').select2({ theme: 'bootstrap4' })
    $('#warna_bahan').select2({ theme: 'bootstrap4' })
    $('#yard_bahan').select2({ theme: 'bootstrap4' })
    $.fn.datetimepicker.Constructor.Default = $.extend({}, 
    $.fn.datetimepicker.Constructor.Default, {
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-arrow-circle-left',
            next: 'fas fa-arrow-circle-right',
            today: 'far fa-calendar-check-o',
            clear: 'fas fa-trash',
            close: 'far fa-times'
        }
    })
    moment.locale("id")
    $('#tanggal_ambil_picker').datetimepicker({
        defaultDate: moment(),
        locale: "id"
    })
    $('#tanggal_kembali_picker').datetimepicker({
        defaultDate: moment(),
        locale: "id"
    })
})
</script>
@endsection