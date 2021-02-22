@extends('layouts.master', ['title' => 'Staf - Tambah Data Pembelian | ' . config('app.name') . '.com' ])

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card card-plain">
    <div class="card-header card-header-info">
        <h4 class="card-title font-weight-bold font-weight-bold">TAMBAH PEMBELIAN</h4>
    </div>

    <div class="card-body bg-light p-4">
        <form action="{{route('staf.pembelian.store')}}" method="post">
            <div class="row mt-4">
                <div class="col-md-6">
                    <label class="text-dark mb-3">Supplier : </label>
                    <select required class="form-control" name="supplier" id="selectSupp">
                        @foreach ($datas as $data)
                        <option value="{{$data->id}}"> {{$data->nama_supplier}} </option>
                        @endforeach
                    </select>
                    <small class="text-rose" style="cursor: pointer" data-toggle="modal" data-target="#modalSupplier">
                        Tambah Supplier
                    </small>
                </div>

                <div class="col-md-6">
                    <label class="text-dark">Nama Barang : </label>
                    <input required name="barang" type="text" class="form-control">
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <label class="text-dark">Total Barang : </label>
                    <input required name="total_barang" type="text" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="text-dark">Harga Satuan : </label>
                    <input required name="harga_satuan" type="text" class="form-control">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <h5 class="text-info font-weight-bold">Total Harga : <span class="text-dark total">Rp. 0</span>
                    </h5>
                </div>

                <div class="col-md-6">
                    <div class="form-group d-flex justify-content-end">
                        <button class="btn btn-info" type="submit">Submit</button>
                    </div>
                </div>
            </div>
            @csrf
        </form>
    </div>
</div>

@include('dashboard.staf.pembelian._modal')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(function (){
        $('#selectSupp').select2();

        $('input[name="total_barang"], input[name="harga_satuan"]').keyup(function(){
           var total = parseInt($('input[name="total_barang"]').val()) || 0;
           var satuan = parseInt($('input[name="harga_satuan"]').val()) || 0;

           let totalHarga = parseInt(total) * parseInt(satuan);
           let res = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalHarga);

           console.log(res);
           $('.total').html(res);
        });
    });
</script>
@endsection
