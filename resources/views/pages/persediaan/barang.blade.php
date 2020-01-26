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
                        <table class="table table-sm table-bordered table-hover text-nowrap text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th width="10%">Induk</th>
                                    <th width="5%">Warna</th>
                                    <th width="5%">Bahan</th>
                                    <th width="1%">Masuk</th>
                                    <th width="1%">Keluar</th>
                                    <th width="1%">Stok Akhir</th>
                                    <th width="1%">Treshold</th>
                                    <th>Status Produksi</th>
                                    <th>HPP</th>
                                    <th>Total Modal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
                                    <td>2.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
                                    <td>3.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
                                    <td>4.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
                                    <td>5.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
                                    <td>6.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
                                    <td>7.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
                                    <td>8.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
                                    <td>9.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
                                    <td>10.</td>
                                    <td>Aara-BiruMuda</td>
                                    <td>Aara</td>
                                    <td>Warna</td>
                                    <td>Diamond</td>
                                    <td>20</td>
                                    <td>5</td>
                                    <td>15</td>
                                    <td>10</td>
                                    <td>
                                        <span class="badge badge-danger">urgent</span>
                                    </td>
                                    <td>Rp. 13.000</td>
                                    <td>Rp. 300.000</td>
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
@endsection

@section('custom-js-adminlte')
@endsection

@section('custom-css')
@endsection

@section('custom-js')
@endsection