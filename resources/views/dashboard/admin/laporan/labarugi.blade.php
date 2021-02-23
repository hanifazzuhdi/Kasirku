@extends('layouts.master', ['title' => 'Laporan Laba Rugi Perusahaan | ' . config('app.name') . '.com'])

@section('content')


<form action="" method="get">
    <div class="d-flex justify-content-between">
        <h3 class="font-weight-bold mt-0 mb-4">Laporan Laba Rugi</h3>

        <div>
            <div class="mr-2 selector" title="Filter Tanggal">
                <input type="month" name="bulan">
            </div>
            <button class=" btn btn-warning btn-sm mt-0" type="submit">Filter</button>
        </div>
        @csrf
    </div>
</form>

<div class="border p-5 rounded bg-white ">

    <h5 class="font-weight-bold">Pendapatan : </h5>
    <div class="ml-4">
        <div class="row">
            <div class="col-3">
                <p>Penjualan Bulanan</p>
            </div>
            <div class="col-1">
                :
            </div>
            Rp.{{number_format($penjualan, '0',',','.')}},-
        </div>
        <div class="row">
            <div class="col-3">
                <p>Jumlah Pendapatan</p>
            </div>
            <div class="col-1">
                :
            </div>
            Rp.{{number_format($penjualan, '0',',','.')}},-
        </div>
    </div>

    <h5 class="font-weight-bold">Penghitungan Laba Kotor : </h5>
    <div class="ml-4">
        <div class="row">
            <div class="col-3">
                <p>Pembelian Bulanan </p>
            </div>
            <div class="col-1">:</div>
            Rp.{{number_format($pembelian,'0', ',','.')}},-
        </div>
        <div class="row">
            <div class="col-3">
                <p class="d-inline mr-5">Laba Kotor </p>
            </div>
            <div class="col-1">
                :
            </div>
            <div>
                <span class="d-block font-weight-bold"> Rp.{{number_format($pembelian, '0',',','.')}} </span>
                <span class="border-bottom my-2 pb-2 d-block"> Rp.{{number_format($penjualan, '0',',','.')}} ( -
                    )</span>
                <span class="font-weight-bold">Rp.{{ number_format($labaKotor, '0', ',', '.')}},- </span>
            </div>
        </div>
    </div>


    <h5 class="font-weight-bold mt-3">Beban Usaha : </h5>
    <div class="ml-4">
        <div class="row">
            <div class="col-3">
                <p> Pengeluaran Tidak Terduga </p>
            </div>
            <div class="col-1">
                :
            </div>
            Rp.{{ number_format($pengeluaran, '0', ',', '.')}},-
        </div>

        <div class="row">
            <div class="col-3">
                <p class="font-weight-bold">Laba/Rugi</p>
            </div>
            <div class="col-1">
                :
            </div>
            <span class="font-weight-bold"> Rp.{{ number_format($labaRugi, '0', ',', '.')}},- </span>
        </div>
    </div>

</div>

@endsection
