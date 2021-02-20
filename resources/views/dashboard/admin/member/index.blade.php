@extends('layouts.master',['title' => 'Daftar Member | tokoku.com'])

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-warning">
                <h4 class="card-title ">Daftar Member Tokoku</h4>
                <p class="card-category"> Hingga {{date('d, F Y')}} </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="mb-3 d-flex justify-content-between">
                        <form class="navbar-form w-19 ml-2 mt-1" action="{{route('admin.member.cari')}}" method="POST">
                            <div class="input-group no-border">
                                <input class="form-control" type="text" name="search" id="search"
                                    placeholder="Cari Kode Member...">
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
                                <form action="{{ route('admin.member.cari') }}" method="post" id="target">
                                    <input class="dropdown-item" type="text" name="datefilter"
                                        placeholder="Filter Tanggal ... " required autocomplete="off" />
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>

                    <table class="table" id="dataTables">
                        <thead class=" text-warning">
                            <th>ID</th>
                            <th>Kode Member</th>
                            <th>Nama</th>
                            <th>Nomor</th>
                            <th>Status Verifikasi</th>
                            <th>Terdaftar Pada</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            <tr>
                                <td>{{$data->id}}</td>
                                <td>{{$data->kode_member}}</td>
                                <td>{{$data->nama}}</td>
                                <td>{{$data->nomor}}</td>
                                <td>{{$data->is_verified == 1 ? 'Aktif' : 'Belum Aktif' }}</td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#modal-show" data-id="{{$data->id}}" href="#">
                                        Detail
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

@include('dashboard.admin.member._modal')

@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(function() {
        // modal
        $('a[data-toggle="modal"]').click(function () {
            let id = $(this).data('id');

            $('.modal-footer form').attr('action', '/admin/member/delete/' + id)

            $.ajax({
                url: '/admin/member/' + id,
                method: 'GET',
                dataType: 'JSON',
                success: function (data){
                    $('#qr_code').attr('src', data.qr_code);
                    $('#kode_member').html(data.kode_member);
                    $('#nama').val(data.nama);
                    $('#nomor').val(data.nomor);
                    $('#status').val(data.is_verified);
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
