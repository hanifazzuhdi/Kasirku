@extends('layouts.master', ['title' => 'Dashboard Admin | ' . config('app.name') . '.com'])

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css">
<link href="{{asset('backend/assets/css/simple-calendar.css')}}" rel="stylesheet" />

@endsection

@section('content')

<div class="row">
    @include('dashboard.admin.home._stats')
</div>
<div class="row">
    @include('dashboard.admin.home._charts')
</div>
<div class="row">
    @include('dashboard.admin.home._tasks')
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="{{asset('backend/assets/js/plugins/jquery.simple-calendar.min.js')}}"></script>

<script>
    $(document).ready(function(){


        // js waktu
        var renderTime = function () {
            var time = new Date();
            clock.textContent = time.toLocaleString('id-ID', {year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric'}) + ' WIB';
        };
        renderTime();

        setInterval(renderTime, 1000);

        $("#calendar").simpleCalendar({
            months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            displayYear: false,
        });
    });
</script>

@include('dashboard.admin.home._script')
@endsection
