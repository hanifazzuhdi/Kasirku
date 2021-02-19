@extends('layouts.master', ['title' => 'Daftar Produk | tokoku.com'])

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title ">Daftar Produk Tokoku</h4>
                        <p class="card-category"> Hingga {{date('d, F Y')}} </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <div class="mb-2 d-flex justify-content-between">
                                <form class="w-19 ml-2" action="{{route('admin.produk.cari')}}" method="post">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="search" id="search"
                                            placeholder="Cari UID Produk...">
                                    </div>
                                    @csrf
                                </form>

                                <div class="my-2">
                                    <form action="{{ route('admin.produk.cari') }}" method="post">
                                        <input class="" required type="text" name="datefilter"
                                            placeholder="Filter Tanggal ... " autocomplete="off" />
                                        <button class="btn btn-warning py-2 px-3 mb-2" type="submit">Filter</button>
                                        @csrf
                                    </form>
                                </div>
                            </div>

                            <table class="table" id="dataTables">
                                <thead class=" text-warning">
                                    <th>UID</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Merek</th>
                                    <th>Stok</th>
                                    <th>Terdaftar Pada</th>
                                    <th>Terakhir diupdate</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                    <tr>
                                        <td>{{$data->uid}}</td>
                                        <td>{{$data->nama_barang}}</td>
                                        <td>{{$data->kategori->nama_kategori}}</td>
                                        <td>{{$data->merek->nama_merek}}</td>
                                        <td>{{$data->stok}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->updated_at}}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#modal-show" data-id="{{$data->id}}"
                                                href="#"> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @isset($datas)
                            {{$datas->links()}}
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.components.modal-produk')

@endsection

@section('scripts')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(function () {
        // modal
        $('a[data-toggle="modal"]').click(function (){
            let id = $(this).data('id');
            console.log(id);

            $.ajax({
                url: '/admin/produk/' + id,
                method: 'GET',
                dataType: 'JSON',
                success: function (data){
                    console.log(data);
                    $('#barcode').attr('src', data.barcode);
                    $('#nama').val(data.nama_barang);
                    $('#stok').val(data.stok);
                    $('#kategori').val(data.kategori_id);
                    $('#merek').val(data.merek_id);
                    $('#harga_beli').val(data.harga_beli);
                    $('#harga_jual').val(data.harga_jual);
                    $('#diskon').val(data.diskon);
                }
            });

        });

        // date picker
        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
            cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>

@endsection
