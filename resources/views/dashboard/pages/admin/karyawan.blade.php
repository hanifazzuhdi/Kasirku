@extends('layouts.master',['title' => 'Daftar Karyawan | tokoku.com'])

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-warning d-flex justify-content-between">
                <div>
                    <h4 class="card-title ">Daftar Karyawan Tokoku</h4>
                    <p class="card-category"> Hingga {{date('d, F Y')}} </p>
                </div>

                <a href="#" class="d-flex align-items-center mr-2 text-black" data-toggle="modal"
                    data-target="#modal-create">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <div class="mb-3 d-flex justify-content-between">
                        <form class="w-19 ml-2" action="{{route('admin.karyawan.cari')}}" method="post">
                            <div class="form-group">
                                <input class="form-control" type="text" name="search" id="search"
                                    placeholder="Cari Id, Email Karyawan...">
                            </div>
                            @csrf
                        </form>

                        <div class="my-2">
                            <form action="{{ route('admin.karyawan.cari') }}" method="post">
                                <input class="" required type="text" name="datefilter" placeholder="Filter Tanggal ... "
                                    autocomplete="off" />
                                <button class="btn btn-warning py-2 px-3 mb-2" type="submit">Filter</button>
                                @csrf
                            </form>
                        </div>
                    </div>

                    <table class="table" id="dataTables">
                        <thead class=" text-warning">
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            <tr>
                                <td>{{$data->id}}</td>
                                <td>{{$data->nama}}</td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->role_id == 2 ? 'Staf' : 'Kasir' }}</td>
                                <td>{{$data->is_verified == 1 ? 'Aktif' : 'Belum Aktif'}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#modal-karyawan" data-id="{{$data->id}}"
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


@include('dashboard.components.modal-karyawan')

@endsection

@section('scripts')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(function() {
    // modal
    $('a[data-toggle="modal"]').click(function () {
                let id = $(this).data('id');
                console.log(id);

                $('#form-karyawan').attr('action', '/admin/add-karyawan');
                $('.modal-footer form').attr('action', '/admin/karyawan/delete/' + id)

                $.ajax({
                    url: '/admin/karyawan/' + id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function (data){
                        console.log(data);
                        $('#avatar').attr('src', data.avatar);
                        $('#email').html(data.email);
                        $('#nama').html(data.nama);
                        $('#alamat').val(data.alamat);
                        $('#umur').val(data.umur)
                        $('#status').val(data.is_verified);
                        $('#verified_at').val(data.email_verified_at);
                        $('#created_at').val(data.created_at);
                        $('#updated_at').val(data.updated_at);
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
