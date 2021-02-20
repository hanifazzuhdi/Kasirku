@extends('layouts.master')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

<div class="col-md-12">
    <div class="card card-plain">
        <div class="card-header card-header-warning">
            <h4 class="card-title mt-0"> Aktifitas Karyawan</h4>
            <p class="card-category">Absen Hari Ini {{ date('d, F Y H:i') }} WIB</p>
        </div>
        <div class="my-2 d-flex justify-content-end">
            <form action="{{ route('admin.aktivitas.cari') }}" method="post">
                <input class="" required type="text" name="datefilter" placeholder="Filter Tanggal ... "
                    autocomplete="off" />
                <button class="btn btn-warning py-2 px-3 mb-2" type="submit">Filter</button>
                @csrf
            </form>
        </div>
        <div class="card-body text-center">
            <div class="table-responsive">
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

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
