@extends('layouts.kasir')

@section('content')

<div class="container py-4 px-5 mt-3 border bg-white rounded">

    <h3 class="mb-4">Transaksi Penjualan</h3>

    <div class="row justify-content-between">
        @include('dashboard.kasir._atas')
    </div>

    <div class="row mt-5">
        @include('dashboard.kasir._tengah')
    </div>

    <div class="mt-4">
        @include('dashboard.kasir._bawah')
    </div>

</div>

{{-- @include('dashboard.kasir._modal') --}}

@endsection
