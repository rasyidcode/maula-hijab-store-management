@extends('layouts.app')

@section('title', 'List Transaksi Kain')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Transaksi Kain</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Transaksi Kain</li>
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
                <!-- TODO: bikin modal untuk menampilkan total value keseluruhan, per kode-kain, dan juga ada daterangepicker untuk mendapatkan total value berdasarkan tanggal_masuk dari ke -->
                <!-- TODO: bikin daterangepicker berdasarkan tanggal_masuk, created_at, updated_at -->
                <!-- TODO: bikin dropdown untuk memfilter data berdasarkan status -->
                <!-- TODO: bikin moneyrangepicker berdasarkan harga, value -->
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_create_transaksi_kain">
                            <i class="fas fa-plus mr-3"></i>Tambah
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="list_transaksi_kain" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Kode</th>
                                    <th>Yard</th>
                                    <th>Harga</th>
                                    <th>Value</th>
                                    <th>Status</th>
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

<!-- Modal create bahan -->
<div class="modal fade" id="modal_create_transaksi_kain">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah transaksi kain</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_create_bahan" role="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="kode_kain">Kode</label>
                                <select id="kode_kain" class="form-control" style="width: 100%;">
                                    <option value="0">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="yard">Yard</label>
                                <input id="yard" type="number" class="form-control" placeholder="Ex : 30" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input id="harga" type="text" class="form-control" placeholder="Ex : Rp. 30.000" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Tanggal Masuk</label>
                                <div class="input-group date" id="tanggal_masuk_picker" data-target-input="nearest">
                                    <input id="tanggal_masuk" type="text" class="form-control datetimepicker-input" data-target="#tanggal_masuk_picker"/>
                                    <div class="input-group-append" data-target="#tanggal_masuk_picker" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar"></i></div>
                                    </div>
                                </div>
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
<div class="modal fade" id="modal_edit_transaksi_kain">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit transaksi kain</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_transaksi_kain" role="form">
                <div class="modal-body">
                    <div class="row">
                        <input id="id2" type="hidden">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="kode_kain2">Kode</label>
                                <select id="kode_kain2" class="form-control" style="width: 100%;">
                                    <option value="0">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="yard2">Yard</label>
                                <input id="yard2" type="number" class="form-control" placeholder="Ex : 30" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="harga2">Harga</label>
                                <input id="harga2" type="text" class="form-control" placeholder="Ex : Rp. 30.000" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Tanggal Masuk</label>
                                <div class="input-group date" id="tanggal_masuk_picker2" data-target-input="nearest">
                                    <input id="tanggal_masuk2" type="text" class="form-control datetimepicker-input" data-target="#tanggal_masuk_picker2"/>
                                    <div class="input-group-append" data-target="#tanggal_masuk_picker2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar"></i></div>
                                    </div>
                                </div>
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
<script src="{{ asset('js/models/model_transaksi_kain.js') }}"></script>
<script src="{{ asset('js/inventory/transaksi_kain.js') }}"></script>
<script>
$(function() {
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
    $('#tanggal_masuk_picker').datetimepicker({
        defaultDate: moment(),
        locale: "id"
    })
    $('#tanggal_masuk_picker2').datetimepicker({
        defaultDate: moment(),
        locale: "id"
    })
    $('#harga').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#harga2').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
})
</script>
@endsection