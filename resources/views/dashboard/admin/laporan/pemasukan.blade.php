@extends('layouts.master', ['title' => 'Laporan Pemasukan | ' . config('app.name') . '.com'])

@section('content')

<h3 class="font-weight-bold mt-0">Laporan Pemasukan</h3>

<form id="target" action="{{route('admin.pemasukan.cari')}}" method="post">
    <div class="d-flex justify-content-end px-2">

        <div class="mr-2 selector" title="Filter Bulan">
            <input type="month" name="bulan" value="{{date('Y-' . $bulan)}}">
        </div>

        <div>
            <button class=" btn btn-warning btn-sm mt-0" type="submit">Filter</button>

            <a href="{{route('admin.pemasukan.export', ['bulan' => $bulan])}}" class="btn btn-info btn-sm mt-0 selector"
                title="Export Data to Excel">
                <i class="fas fa-file-excel"></i>
            </a>
        </div>
        @csrf
    </div>
    @csrf
</form>

<div class="border p-4 rounded bg-white">
    {{-- stats --}}
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">paid</i>
                    </div>
                    <p class="card-category">Pemasukan</p>
                    <h3 class="card-title">
                        Rp.{{number_format($hari, '0', ',', '.')}},-
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i>Pemasukan Hari Ini
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">payments</i>
                    </div>
                    <p class="card-category">Total Pemasukan</p>
                    <h3 class="card-title">
                        Rp.{{number_format($tBulan, '0', ',', '.')}},-
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i>Pemasukan Bulan {{$bulanName}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Data --}}
    <table class="table table-bordered text-center">
        <thead class="thead-light">
            <th>NO</th>
            <th>Total Pemasukan</th>
            <th>Dibuat Pada</th>
        </thead>
        <tbody>
            @forelse ($pemasukan as $item)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td>Rp.{{number_format($item->harga_total,'0', ',', '.')}}</td>
                <td>{{($item->created_at)}}</td>
            </tr>
            @empty
            <div class="text-dark font-weight-bold text-center alert alert-warning" role="alert">
                Data Belum Ada
            </div>
            @endforelse
        </tbody>

    </table>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#daterange').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#daterange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        let myForm = $("#target");

        $('.ranges ul li').click(function (){

            let data = $(this).data('range-key');
            console.log(data);

            if (data != 'Custom Range'){
                setTimeout(function () {
                    myForm.submit();
                }, 10);
            }
        });

        $(".applyBtn").click(function(){
            setTimeout(function () {
                myForm.submit();
            }, 10);
        });

        $( ".selector" ).tooltip({ show: { effect: 'none', duration: 0 } });

    });
</script>
@endsection
