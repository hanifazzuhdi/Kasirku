@extends('layouts.master', ['title' => 'Staff - Tambah Produk | ' . config('app.name') . '.com'])

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

<div class="card card-plain">
    <div class="card-header card-header-info">
        <h4 class="card-title font-weight-bold font-weight-bold">TAMBAH PRODUK</h4>
    </div>

    <div class="card-body bg-light p-4">
        <form action="{{route('staf.produk.store')}}" method="post">
            <div class="row mt-4">
                <div class="col-md-6">
                    <label class="text-dark">Nama Barang : </label>
                    <input required name="nama_barang" type="text" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="text-dark mb-3">Kategori : </label>
                    <select required class="form-control selectSupp" name="kategori_id">
                        @foreach ($kategoris as $kategori)
                        <option value="{{$kategori->id}}"> {{$kategori->nama_kategori}} </option>
                        @endforeach
                    </select>
                    <small class="text-rose kategori" style="cursor: pointer" data-toggle="modal"
                        data-target="#modalProduk">
                        Tambah Kategori
                    </small>
                </div>

                <div class="col-md-3">
                    <label class="text-dark mb-3">Merek : </label>
                    <select required class="form-control selectSupp" name="merek_id">
                        @foreach ($mereks as $merek)
                        <option value="{{$merek->id}}"> {{$merek->nama_merek}} </option>
                        @endforeach
                    </select>
                    <small class="text-rose merek" style="cursor: pointer" data-toggle="modal"
                        data-target="#modalProduk">
                        Tambah Merek
                    </small>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <label class="text-dark">Harga Beli : </label>
                    <input required name="harga_beli" type="text" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="text-dark">Harga Jual : </label>
                    <input required name="harga_jual" type="text" class="form-control">
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <label class="text-dark">Total Barang : </label>
                    <input required name="stok" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="text-dark">Diskon : </label>
                    <input required name="diskon" type="text" class="form-control">
                </div>
            </div>

            {{-- Button --}}
            <div class="text-right mt-3">
                <div class="form-group d-flex justify-content-end">
                    <button class="btn btn-info" type="submit">Submit</button>
                </div>
            </div>
            @csrf
        </form>
    </div>
</div>

@include('dashboard.staf.produk._tambah')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function (){
        $('.selectSupp').select2();

        // modal
        $('.kategori').click(function () {
            $('h5').html('Tambah Kategori');
            $('.modal label').html('Nama Kategori');
            $('.modal input[autocomplete="off"]').attr('name', 'nama_kategori');
            $('.modal-body form').attr('action', '/staff/tambah-kategori');
        });

        $('.merek').click(function () {
            $('h5').html('Tambah Merek');
            $('.modal label').html('Nama Merek');
            $('.modal input[autocomplete="off"]').attr('name', 'nama_merek');
            $('.modal-body form').attr('action', '/staff/tambah-merek');
        });

    });
</script>
@endsection
