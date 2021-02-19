@extends('layouts.master')

@section('content')

<div class="card">
    <div class="pb-2 card-header border-bottom d-flex justify-content-between bg-light">
        <h5>Tambah Data Pengeluaran</h5>

        <a href="#collapseCard" data-toggle="collapse" role="button">
            <span class="material-icons">
                keyboard_arrow_down
            </span>
        </a>
    </div>

    <div class="collapse" id="collapseCard">
        <div class="card-body mt-4">
            <form action="{{route('admin.pengeluaran.store')}}" method="post">
                <div class="form-group">
                    <label for="">Nama Pengeluaran : </label>
                    <input name="nama_pengeluaran" type="text" class="form-control">
                </div>

                <div class="form-group mt-4">
                    <label for="">Total Pengeluaran : </label>
                    <input name="jumlah" type="text" class="form-control">
                </div>

                <div class="form-group d-flex justify-content-end mt-3">
                    <button class="btn btn-warning" type="submit">Submit</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header border-bottom card-header-warning">
                <h4 class="card-title">Pembelian Terakhir</h4>
                <p class="card-category"> Diperbarui {{ date('d F Y, H:i ') }} WIB</p>
            </div>

            @foreach ($pengeluarans as $pengeluaran)
            <div class="card-body list-group border-bottom">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">
                        {{$pengeluaran->nama_pengeluaran}}
                    </h6>
                    <div>
                        <small> {{$pengeluaran->updated_at}} </small>
                    </div>
                </div>
                <h6 class="mb-1"> Pengeluaran : IDR. {{$pengeluaran->jumlah}}</h6>
            </div>
            @endforeach
            <div class="card-footer d-flex justify-content-end mr-4">
                <a href="#"> See all </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header border-bottom card-header-warning">
                <h4 class="card-title">Pembelian Terakhir</h4>
                <p class="card-category"> Diperbarui {{ date('d F Y, H:i ') }} WIB</p>
            </div>

            @foreach ($pembelians as $pembelian)
            <div class="card-body list-group border-bottom">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">
                        {{$pembelian->nama_pengeluaran}}
                    </h6>
                    <div>
                        <small> {{$pembelian->updated_at}} </small>
                    </div>
                </div>
                <h6 class="mb-1"> Pengeluaran : IDR. {{$pembelian->jumlah}}</h6>
            </div>
            @endforeach
            <div class="card-footer d-flex justify-content-end mr-4">
                <a href="#"> See all </a>
            </div>
        </div>
    </div>
</div>

@endsection
