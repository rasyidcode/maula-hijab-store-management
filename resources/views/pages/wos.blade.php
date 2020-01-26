@extends('layouts.app')

@section('title', 'Daftar Induk')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data WOS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Data WOS</li>
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
                            <button type="button" class="btn btn-block btn-primary btn-sm">Tambah WOS</button>
                        </div>
    
                        <div class="card-tools">
                            <div class="input-group input-group-sm p-1" style="width: 250px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Cari Penjahit...">
            
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-nowrap text-center table-sm">
                            <thead>
                                <tr>
                                    <th width="10%">Kode</th>
                                    <th>Kode Barang</th>
                                    <th>Yard</th>
                                    <th>PCS</th>
                                    <th>Ratio</th>
                                    <th>Tanggal Ambil</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status Barang</th>
                                    <th>Status Bayar</th>
                                    <th>Jumlah Kembali</th>
                                    <th>Nama Penjahit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>TPDL-MERAH</td>
                                    <td>71</td>
                                    <td>48</td>
                                    <td>1.722222222</td>
                                    <td>Mei, 12 Desember 2019, 12:00:01</td>
                                    <td>Mei, 15 Desember 2019, 12:00:01</td>
                                    <td>Sebagian</td>
                                    <td>Belum dibayar</td>
                                    <td>20</td>
                                    <td>Susi Puji Astuti</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="#">
                                            <i class="fas fa-eye">
                                            </i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="#">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.</td>
                                    <td>TPDL-MERAH</td>
                                    <td>71</td>
                                    <td>48</td>
                                    <td>1.722222222</td>
                                    <td>Mei, 12 Desember 2019, 12:00:01</td>
                                    <td>Mei, 15 Desember 2019, 12:00:01</td>
                                    <td>Sebagian</td>
                                    <td>Belum dibayar</td>
                                    <td>20</td>
                                    <td>Susi Puji Astuti</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="#">
                                            <i class="fas fa-eye">
                                            </i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="#">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.</td>
                                    <td>TPDL-MERAH</td>
                                    <td>71</td>
                                    <td>48</td>
                                    <td>1.722222222</td>
                                    <td>Mei, 12 Desember 2019, 12:00:01</td>
                                    <td>Mei, 15 Desember 2019, 12:00:01</td>
                                    <td>Sebagian</td>
                                    <td>Belum dibayar</td>
                                    <td>20</td>
                                    <td>Susi Puji Astuti</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="#">
                                            <i class="fas fa-eye">
                                            </i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="#">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1.</td>
                                    <td>TPDL-MERAH</td>
                                    <td>71</td>
                                    <td>48</td>
                                    <td>1.722222222</td>
                                    <td>Mei, 12 Desember 2019, 12:00:01</td>
                                    <td>Mei, 15 Desember 2019, 12:00:01</td>
                                    <td>Sebagian</td>
                                    <td>Belum dibayar</td>
                                    <td>20</td>
                                    <td>Susi Puji Astuti</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="#">
                                            <i class="fas fa-eye">
                                            </i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="#">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
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
@endsection

@section('custom-js-adminlte')
@endsection

@section('custom-css')
@endsection

@section('custom-js')
@endsection