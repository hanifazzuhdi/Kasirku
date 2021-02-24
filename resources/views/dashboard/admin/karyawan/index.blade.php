@extends('layouts.master',['title' => 'Daftar Karyawan | ' . config('app.name') . '.com'])

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-warning d-flex justify-content-between">
                <div>
                    <h4 class="card-title font-weight-bold ">Daftar Karyawan Tokoku</h4>
                    <p class="card-category"> Hingga {{date('d, F Y H:i')}} WIB </p>
                </div>

                <a class="mt-2" style="cursor: pointer;" data-toggle="modal" data-target="#modal-create">
                    <i class="material-icons">add_box</i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <div class="mb-3 d-flex justify-content-between">

                        <form class="navbar-form w-19 mt-1 ml-2" action="{{route('admin.karyawan.cari')}}"
                            method="POST">
                            <div class="input-group no-border">
                                <input class="form-control" type="text" name="search" id="search"
                                    placeholder="Cari ID, Email Karyawan...">
                                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                    <i class="material-icons">search</i>
                                    <div class="ripple-container"></div>
                                </button>
                                @csrf
                            </div>
                        </form>

                        <div class="mt-1 mr-3">
                            <a class="btn btn-white btn-round btn-just-icon" style="cursor: pointer;" title="Filter"
                                id="dropdownMember" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">
                                    filter_list
                                </i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMember">
                                <small class="text-rose ml-2">Filter Tanggal</small>
                                <form action="{{ route('admin.karyawan.cari') }}" method="post" id="target">
                                    <input class="dropdown-item" type="text" name="datefilter"
                                        placeholder="Pilih Tanggal" required autocomplete="off" />
                                    @csrf
                                </form>
                                <small class="text-rose ml-2">Filter Jabatan</small>
                                <form action="{{ route('admin.karyawan.staf') }}" method="post" id="target">
                                    <button class="dropdown-item w-95" type="submit">Staf</button>
                                    @csrf
                                </form>
                                <form action="{{ route('admin.karyawan.kasir') }}" method="post" id="target">
                                    <button class="dropdown-item w-95" type="submit">Kasir</button>
                                    @csrf
                                </form>
                            </div>
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
                                <td>{{$data->is_verified == 1 ? 'Karyawan Aktif' : 'Tidak Aktif'}}</td>
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

@include('dashboard.admin.karyawan._modal')

@endsection

@section('scripts')
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

        let myForm = $("#target");

        $(".applyBtn").click(function(){
            setTimeout(function () {
                myForm.submit();
            }, 10);
        });
    });
</script>
@endsection
