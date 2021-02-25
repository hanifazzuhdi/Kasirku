@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @isset($nomor, $token)
                    <form method="POST" action="{{ route('resetPassword') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Nomor Telepon : ') }}</label>

                            <div class="col-md-6">
                                <input type="text" value="{{$nomor}}" readonly class="form-control">
                                <input type="hidden" name="token" value="{{$token}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">
                                {{ __('Password Baru : ') }}
                            </label>

                            <div class="col-md-6">
                                <input class="form-control" type="text" name="password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">
                                {{ __('Konfirmasi Password : ') }}
                            </label>

                            <div class="col-md-6">
                                <input class="form-control" type="text" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @endisset

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
