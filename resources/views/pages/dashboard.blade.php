@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Laporan</li>
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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Laporan Transaksi Kain</h3>
        
                        <div class="card-tools"></div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="list_laporan_transaksi_kain" class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Kode Kain</th>
                                        <th>Total Yard</th>
                                        <th>Total Value</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Laporan Barang</h3>
        
                        <div class="card-tools"></div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="list_laporan_barang" class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>On Progress</th>
                                        <th>Stok Ready</th>
                                        <th>Total Value</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('custom-js')
<script>
$(function() {
    axios.get('/api/v1/laporan/transaksi_kain', { headers: General.getHeaders() })
        .then(function(res) {
            const laporanTransaksiKain = res.data.data

            laporanTransaksiKain.forEach(function(kain) {
                $("#list_laporan_transaksi_kain").find('tbody').append(`
                    <tr>
                        <td>${kain.kode_kain}</td>
                        <td><span class="badge badge-warning">${kain.total_yard}</span></td>
                        <td>${General.rupiahFormat(kain.total_value, '')}</td>
                    </tr>
                `)
            })
        })
        .catch(function(err) {
            console.log(err)
        })

    axios.get('/api/v1/laporan/barang', { headers: General.getHeaders() })
        .then(function(res) {
            const laporanBarang = res.data.data

            laporanBarang.forEach(function(barang) {

                

                $("#list_laporan_barang").find('tbody').append(`
                    <tr>
                        <td>${barang.kode_barang}</td>
                        <td><span class="badge badge-success">${kain.on_progress}</span></td>
                        <td><span class="badge badge-success">${kain.stok_ready}</span></td>
                        <td>${General.rupiahFormat(kain.total_value, '')}</td>
                    </tr>
                `)
            })
        })
        .catch(function(err) {
            console.log(err)
        })
})
</script>
@endsection