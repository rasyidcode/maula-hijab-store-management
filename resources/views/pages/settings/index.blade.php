@extends('layouts.app')

@section('title', 'Settings')

@section('custom-css')
<style>
table#list_warna tr {
    cursor: pointer;
}
table#list_bahan tr {
    cursor: pointer;
}
.overlay.dark i.fas.fa-2x {
	animation: spin 2.5s linear infinite;
}
@keyframes spin {
	0% {
		transform: rotateZ(0);
	}
	100% {
		transform: rotateZ(360deg);
	}
}
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Settings</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Settings</li>
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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title p-1">List Warna Kain</h3>
                        <button id="button_create_warna" type="button" class="btn btn-primary btn-sm float-right">Tambah Warna</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="list_warna" class="table table-bordered">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Warna</th>
                                    <th style="width: 80px">Hex Code</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <p class="p-0 m-0">*Klik sekali untuk mengedit.</p>
                        <p class="p-0 m-0">*Double klik untuk menghapus.</p>
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="">&raquo;</a></li>
                        </ul>
                    </div>
                    <div id="warna_loading" class="overlay dark">
                        <i class="fas fa-2x fa-sync-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title p-1">List Bahan</h3>
                        <button id="button_create_bahan" type="button" class="btn btn-primary btn-sm float-right">Tambah Bahan</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="list_bahan" class="table table-bordered">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <p class="p-0 m-0">*Klik sekali untuk mengedit.</p>
                        <p class="p-0 m-0">*Double klik untuk menghapus.</p>
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="">&raquo;</a></li>
                        </ul>
                    </div>
                    <div id="bahan_loading" class="overlay dark">
                        <i class="fas fa-2x fa-sync-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal form tambah warna -->
<div class="modal fade" id="modal_create_warna">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Warna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_create_warna" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input id="name" type="text" class="form-control" placeholder="Ex : Merah" required>
                    </div>
                    <!-- Color Picker -->
                    <div class="form-group">
                        <label for="hex_code">Hexcode (Opsional)</label>
                        <div class="input-group hex_code_kain">
                            <input id="hex_code" type="text" class="form-control">

                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-square"></i></span>
                            </div>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal form edit warna -->
<div class="modal fade" id="modal_edit_warna">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Warna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_warna" role="form">
                <input id="id_warna_edit" type="hidden" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name2">Nama</label>
                        <input id="name2" type="text" class="form-control" placeholder="Ex : Merah" required>
                    </div>
                    <!-- Color Picker -->
                    <div class="form-group">
                        <label for="hex_code2">Hexcode (Opsional)</label>
                        <div class="input-group hex_code_kain">
                            <input id="hex_code2" type="text" class="form-control">

                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-square"></i></span>
                            </div>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal form tambah bahan -->
<div class="modal fade" id="modal_create_bahan">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Bahan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_create_bahan" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_bahan">Nama</label>
                        <input id="nama_bahan" type="text" class="form-control" placeholder="Ex : Diamond" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi (Opsional)</label>
                        <textarea id="deskripsi" class="form-control" placeholder="Ex : Bahan nya halus"></textarea>
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

<!-- modal form edit bahan -->
<div class="modal fade" id="modal_edit_bahan">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Bahan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_bahan" role="form">
                <input id="id_bahan_edit" type="hidden" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_bahan2">Nama</label>
                        <input id="nama_bahan2" type="text" class="form-control" placeholder="Ex : Diamond" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi2">Deskripsi (Opsional)</label>
                        <textarea id="deskripsi2" class="form-control" placeholder="Ex : Bahan nya halus"></textarea>
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
<script src="{{ asset('js/settings.js') }}"></script>
<script>
//color picker with addon
$('.hex_code_kain').colorpicker()
$('.hex_code_kain').on('colorpickerChange', function(event) {
    $('.hex_code_kain .fa-square').css('color', event.color.toString());
});
</script>
@endsection