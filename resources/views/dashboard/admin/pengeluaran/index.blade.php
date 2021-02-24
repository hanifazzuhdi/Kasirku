@extends('layouts.master', ['title' => 'Pengeluaran Perusahaan | ' . config('app.name') . '.com'])

@section('content')

<div class="card">
    @include('dashboard.admin.pengeluaran._tambah')
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        @include('dashboard.admin.pengeluaran._pengeluaran')
    </div>

    <div class="col-lg-6 col-md-12">
        @include('dashboard.admin.pengeluaran._pembelian')
    </div>
</div>

@endsection
