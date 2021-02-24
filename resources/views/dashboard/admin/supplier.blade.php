@extends('layouts.master', ['title' => 'Daftar Supplier | ' . config('app.name') .'.com'])

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title font-weight-bold ">Daftar Supplier Tokoku</h4>
                        <p class="card-category"> Hingga {{date('d, F Y')}} </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <div class="mb-3 d-flex justify-content-between">
                                <form class="navbar-form w-19 ml-2 mt-1" action="{{route('admin.supplier.cari')}}"
                                    method="POST">
                                    <div class="input-group no-border">
                                        <input class="form-control" type="text" name="search" id="search"
                                            placeholder="Cari Supplier...">
                                        <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                            <i class="material-icons">search</i>
                                            <div class="ripple-container"></div>
                                        </button>
                                        @csrf
                                    </div>
                                </form>

                                <div class="mt-1 mr-3">
                                    <a class="btn btn-white btn-round btn-just-icon" style="cursor: pointer;"
                                        title="Filter" id="dropdownMember" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="material-icons">
                                            filter_list
                                        </i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMember">
                                        <small class="text-rose ml-2">Filter Tanggal</small>
                                        <form action="{{ route('admin.supplier.cari') }}" method="post" id="target">
                                            <input class="dropdown-item" type="text" name="datefilter"
                                                placeholder="Filter Tanggal ... " required autocomplete="off" />
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <table class="table text-center" id="dataTables">
                                <thead class=" text-warning">
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Jumlah Transaksi</th>
                                    <th>Terdaftar Pada</th>
                                    <th>Terakhir diperbarui</th>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                    <tr>
                                        <td>{{$data->id}}</td>
                                        <td>{{$data->nama_supplier}}</td>
                                        <td>{{$data->jml_order}} Transaksi</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->updated_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @isset($datas)
                            {{$datas->links()}}
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // date picker
    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
        cancelLabel: 'Clear'
        }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    let myForm = $("#target");

    $(".applyBtn").click(function(){
        setTimeout(function () {
            myForm.submit();
        }, 10);
    });

</script>
@endsection
