@extends('layouts.master', ['title' => 'Laporan Laba Rugi Perusahaan | ' . config('app.name') . '.com'])

@section('content')

<h3 class="font-weight-bold mt-0">Laporan Laba Rugi</h3>

<form action="{{route('admin.labarugi.cari')}}" method="post">
    <div class="d-flex justify-content-end">

        <div class="mr-2 selector" title="Filter Bulan">
            <input type="month" name="bulan" value="{{date('Y-' . $bulan)}}">
        </div>
        <button class=" btn btn-warning btn-sm mt-0" type="submit">Filter</button>

        @csrf
    </div>
</form>

@if (date('m') < $bulan) <div class="alert alert-warning" role="alert">
    Data Belum Ada
    </div>
    @endif

    <div class="border p-5 rounded bg-white">

        @include('dashboard.admin.laporan._penghitungan')

        @include('dashboard.admin.laporan._labakotor')

        @include('dashboard.admin.laporan._beban')

    </div>

    @endsection
