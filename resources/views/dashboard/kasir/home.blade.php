@extends('layouts.kasir')

@section('content')

<div class="container py-4 px-5 my-4 border bg-white rounded">

    <h3 class="mb-5">Transaksi Penjualan</h3>

    <div class="row justify-content-between">
        @include('dashboard.kasir._atas')
    </div>

    <div class="row mt-5">
        @include('dashboard.kasir._tengah')
    </div>

    <div class="row mt-5 justify-content-between">
        @include('dashboard.kasir._bawah')
    </div>

</div>

{{-- @include('dashboard.kasir._modal') --}}

@endsection
