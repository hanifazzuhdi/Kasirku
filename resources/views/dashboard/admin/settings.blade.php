@extends('layouts.master', ['title' => ' Settings | ' . config('app.name') . '.com'])

@section('content')

<div class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Pengaturan</h4>
                    </div>
                    <div class="card-body p-4 mt-2">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Nama Usaha</label>
                                        <input type="text" class="form-control" value="{{config('app.name')}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Email</label>
                                        <input type="email" class="form-control" value="{{Auth::user()->email}}"
                                            disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Alamat</label>
                                        <input type="text" class="form-control" value="{{Auth::user()->alamat}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tentang Perusahaan</label>
                                        <div class="form-group">
                                            <textarea class="form-control"
                                                rows="5">Don't be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning pull-right">Update Profile</button>
                            <div class="clearfix"></div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="javascript:;">
                            <img class="img bg-white" src="{{Auth::user()->avatar}}" />
                        </a>
                    </div>
                    <div class="card-body">
                        <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                        <h4 class="card-title">{{Auth::user()->nama}}</h4>
                        <p class="card-description">
                            Don't be scared of the truth because we need to restart the human foundation in truth And I
                            love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
