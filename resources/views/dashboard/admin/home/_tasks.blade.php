<div class="col-lg-6 col-md-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Kalender</h4>
            <p class="card-category" id="clock">Loading ...</p>
        </div>
        <div class="card-body">

            <div id="calendar"></div>

        </div>
    </div>
</div>

<div class="col-lg-6 col-md-12">
    <div class="card">
        <div class="card-header card-header-warning">
            <h4 class="card-title">Aktifitas Karyawan</h4>
            <p class="card-category"> Updated At {{ date('d F Y, H:i ') }} WIB</p>
        </div>

        <div class="card-body list-group">
            @foreach ($logs as $log)
            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">
                        {{$log->activity}}
                        Activity
                    </h5>
                    <small class="text-muted">{{$log->updated_at}}</small>
                </div>
                <p class="mb-1">{{$log->pesan}}</p>
            </a>
            @endforeach

        </div>
        <div class="card-footer d-flex justify-content-end mr-4">
            <a href="{{route('admin.aktivitas')}}"> See all </a>
        </div>
    </div>
</div>
