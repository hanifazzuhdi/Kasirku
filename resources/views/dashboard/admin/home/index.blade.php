@extends('layouts.master', ['title' => 'Dashboard Admin | ' . config('app.name') . '.com'])

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css">
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
@include('dashboard.admin.home._script')
@endsection
