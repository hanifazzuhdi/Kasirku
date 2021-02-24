@extends('layouts.master',['title' => 'Absensi Karyawan | ' . config('app.name') .'.com'] )

@section('content')
<div class="col-md-12">
    <div class="card card-plain">
        <div class="card-header card-header-warning">
            <h4 class="card-title font-weight-bold mt-0"> Aktifitas Karyawan</h4>
            <p class="card-category">Absen Hari Ini {{ date('d, F Y') }}</p>
        </div>
        <div class="my-2 d-flex justify-content-end">

            <div class=" mr-3">
                <a class="btn btn-white btn-round btn-just-icon" style="cursor: pointer;" title="Filter"
                    id="dropdownMember" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">
                        filter_list
                    </i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMember">
                    <small class="text-rose ml-2">Filter Tanggal</small>
                    <form action="{{ route('admin.aktivitas.cari') }}" method="post" id="target">
                        <input class="dropdown-item" type="text" name="datefilter" placeholder="Filter Tanggal ... "
                            required autocomplete="off" />
                        @csrf
                    </form>
                </div>
            </div>

        </div>
        <div class="card-body text-center">
            <div class="table-responsive ">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Device</th>
                        <th>Aktivitas</th>
                        <th>Data Dibuat</th>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->role }}</td>
                            <td>{{ $data->device }} App </td>
                            <td>{{ $data->activity }}</td>
                            <td>{{ $data->created_at }} WIB </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$datas->links()}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
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
</script>
@endsection
