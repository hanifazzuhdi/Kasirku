@extends('layouts.master')

@section('content')

<div class="card">
    <div class="card-header-warning">
        <h5>Tambah Data Pengeluaran</h5>
    </div>

    <div class="card-body mt-4">
        <form action="" method="post">
            <div class="form-group">
                <label for="">Pengeluaran : </label>
                <input type="text" class="form-control">
            </div>

            <div class="form-group mt-4">
                <label for="">Total Pengeluaran : </label>
                <input type="text" class="form-control">
            </div>

            <div class="form-group d-flex justify-content-end mt-3">
                <button class="btn btn-warning" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Pengeluaran Terakhir</h4>
                <p class="card-category"> Diperbarui {{ date('d F Y, H:i ') }} WIB</p>
            </div>

            <div class="card-body list-group">
                {{-- @foreach ($logs as $log) --}}
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            {{-- {{$log->activity}} --}}
                            Activity
                        </h5>
                        {{-- <small class="text-muted">{{$log->updated_at}}</small> --}}
                    </div>
                    {{-- <p class="mb-1">{{$log->pesan}}</p> --}}
                </a>
                {{-- @endforeach --}}

            </div>
            <div class="card-footer d-flex justify-content-end mr-4">
                <a href="#"> See all </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Pembelian Terakhir</h4>
                <p class="card-category"> Diperbarui {{ date('d F Y, H:i ') }} WIB</p>
            </div>

            <div class="card-body list-group">
                {{-- @foreach ($logs as $log) --}}
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            {{-- {{$log->activity}} --}}
                            Activity
                        </h5>
                        {{-- <small class="text-muted">{{$log->updated_at}}</small> --}}
                    </div>
                    {{-- <p class="mb-1">{{$log->pesan}}</p> --}}
                </a>
                {{-- @endforeach --}}

            </div>
            <div class="card-footer d-flex justify-content-end mr-4">
                <a href="#"> See all </a>
            </div>
        </div>
    </div>
</div>

@endsection
