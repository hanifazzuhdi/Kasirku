@extends('layouts.master', ['title' => 'Dashboard Staff | ' . config('app.name') . '.com'])

@section('content')

<div class="container-fluid border bg-white p-4">
    <h3 class="font-weight-bold text-center">Selamat {{$sapa}} {{Auth::user()->nama}}... SELAMAT BEKERJA !</h3>

    <div class="mt-5 text-center">
        <a href="{{route('staf.pembelian')}}" class="text-white btn btn-success mr-2">Cek Data Pembelian</a>

        <a href="{{route('staf.produk')}}" class="text-white btn btn-info">Cek Data Produk</a>
    </div>
</div>

@endsection
