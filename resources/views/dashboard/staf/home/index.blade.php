@extends('layouts.master', ['title' => 'Dashboard Staff | ' . config('app.name') . '.com'])

@section('content')

{{-- Sapa --}}
<div class="container-fluid border bg-white p-4 text-center">
    <h3 class="font-weight-bold">Selamat {{$sapa}} {{Auth::user()->nama}}... SELAMAT BEKERJA !</h3>
</div>


@endsection
