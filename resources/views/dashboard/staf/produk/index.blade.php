@extends('layouts.master', ['title' => 'Staff - Daftar Produk | ' . config('app.name') . '.com'])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title font-weight-bold font-weight-bold">Daftar Produk</h4>
                        <p class="card-category"> Hingga {{date('d, F Y H:i')}} WIB</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="mb-3 d-flex justify-content-between">
                                <form class="navbar-form w-19 ml-2 mt-1" action="{{route('staf.produk.cari')}}"
                                    method="POST">
                                    <div class="input-group no-border">
                                        <input class="form-control" type="text" name="search" id="search"
                                            placeholder="Cari UID Produk...">
                                        <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                            <i class="material-icons">search</i>
                                            <div class="ripple-container"></div>
                                        </button>
                                        @csrf
                                    </div>
                                </form>

                                <div class="mt-1 mr-3">
                                    <a class="btn btn-white btn-round btn-just-icon" style="cursor: pointer;"
                                        title="Filter" id="dropdownMember" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="material-icons">
                                            filter_list
                                        </i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMember">
                                        <small class="text-rose ml-2">Filter Tanggal</small>
                                        <form action="{{ route('staf.produk.cari') }}" method="post" id="target">
                                            <input class="dropdown-item dropdown-item-staf" type="text"
                                                name="datefilter" placeholder="Filter Tanggal ... " required
                                                autocomplete="off" />
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <table class="table" id="dataTables">
                                <thead class=" text-info">
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
                                                href="{{route('admin.produk.show', [$data->id])}}"> Detail
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

@include('dashboard.staf.produk._modal')

@endsection

@section('scripts')
<script>
    $(function () {
        // modal
        $('a[data-toggle="modal"]').click(function (){
            let id = $(this).data('id');
            console.log(id);

            $('form').attr('action', '/staff/update-produk/' + id);

            $.ajax({
                url: '/staff/produk/' + id,
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

        let myForm = $("#target");

        $(".applyBtn").click(function(){
            setTimeout(function () {
                myForm.submit();
            }, 10);
        });
    });
</script>
@endsection
