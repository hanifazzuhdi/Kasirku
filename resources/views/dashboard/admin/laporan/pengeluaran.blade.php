@extends('layouts.master', ['title' => 'Laporan Pengeluaran | ' . config('app.name') . '.com'])

@section('content')

<h3 class="font-weight-bold mt-0">Laporan Pengeluaran</h3>

<form id="target" action="{{route('admin.pengeluaran.cari')}}" method="post">
    <div class="d-flex justify-content-end px-2">

        <div class="mr-2 selector" title="Filter Bulan">
            <input type="month" name="bulan" value="{{date('Y-' . $bulan)}}">
        </div>

        <button class=" btn btn-warning btn-sm mt-0" type="submit">Filter</button>
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
                    <p class="card-category">Pengeluaran</p>
                    <h3 class="card-title">
                        Rp.{{number_format($hari, '0', ',', '.')}},-
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i>Pengeluaran Hari Ini
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
                    <p class="card-category">Total Pengeluaran</p>
                    <h3 class="card-title">
                        Rp.{{number_format($tBulan, '0', ',', '.')}},-
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i>Pengeluaran Bulan {{$bulanName}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Data --}}
    <table class="table table-bordered text-center">
        <thead class="thead-light">
            <th>NO</th>
            <th>Pengeluaran</th>
            <th>Total Pengeluaran</th>
            <th>Jenis Pengeluaran</th>
            <th>Dibuat Pada</th>
        </thead>
        <tbody>
            @forelse ($pengeluaran as $item)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{$item->nama_pengeluaran}}</td>
                <td>Rp.{{number_format($item->jumlah,'0', ',', '.')}}</td>
                <td>{{$item->jenis}}</td>
                <td>{{($item->created_at)}}</td>
            </tr>
            @empty
            <div class="alert alert-warning" role="alert">
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
