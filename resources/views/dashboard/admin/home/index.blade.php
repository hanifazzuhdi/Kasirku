@extends('layouts.master')

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
