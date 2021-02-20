@extends('layouts.master')

@section('content')

{{-- stats --}}
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">recent_actors</i>
                </div>
                <p class="card-category">Member Aktif</p>
                <h3 class="card-title">
                    {{-- {{$member}} --}}
                </h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">update</i>Hingga Saat Ini
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-receipt" aria-hidden="true"></i>
                </div>
                <p class="card-category">Total Transaksi</p>
                <h3 class="card-title">+245</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Transaksi Hari Ini
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-money-bill" aria-hidden="true"></i>
                </div>
                <p class="card-category">Penjualan</p>
                <h3 class="card-title">$34,245</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Transaksi Hari Ini
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-file-invoice-dollar" aria-hidden="true"></i>
                </div>
                <p class="card-category">Keuntungan</p>
                <h3 class="card-title">75</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">receipt_long</i> Transaksi Hari Ini
                </div>
            </div>
        </div>
    </div>
</div>

{{-- info pembelian terakhir --}}

{{-- info stok singkat --}}

@endsection
