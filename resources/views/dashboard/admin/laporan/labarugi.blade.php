@extends('layouts.master', ['title' => 'Laporan Laba Rugi Perusahaan | ' . config('app.name') . '.com'])

@section('content')

<form action="{{route('admin.labarugi.cari')}}" method="post">
    <div class="d-flex justify-content-end">

        <div class="mr-2 selector" title="Filter Bulan">
            <input type="month" name="bulan" value="{{date('Y-' . $bulan)}}">
        </div>

        <div>
            <button class=" btn btn-warning btn-sm mt-0" type="submit">Filter</button>
            <button onclick="printDiv('laporan')" class=" btn btn-info btn-sm mt-0 selector"
                title="Export Data ke Excel">
                <i class="material-icons">
                    print
                </i>
            </button>
        </div>
        @csrf
    </div>
</form>

<div id="laporan">
    @if (date('m') < $bulan) <div class="alert alert-warning" role="alert">
        Data Belum Ada
</div>
@endif

<div class="border px-5 pb-5 rounded bg-white">

    <h3 class="py-3 text-center font-weight-bold">Laporan Laba/Rugi Bulan {{$bulanName}}</h3>

    @include('dashboard.admin.laporan._penghitungan')

    @include('dashboard.admin.laporan._labakotor')

    @include('dashboard.admin.laporan._beban')

</div>
</div>

@endsection

@section('scripts')
<script>
    function printDiv(divName){
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }

    $(function (){
        $( ".selector" ).tooltip({ show: { effect: 'none', duration: 0 } });
    })
</script>
@endsection
