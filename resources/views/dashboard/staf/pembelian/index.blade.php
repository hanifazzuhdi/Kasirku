@extends('layouts.master', ['title' => 'Staff - Data Pembelian | ' . config('app.name') . '.com'])

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title font-weight-bold font-weight-bold mt-0">Data Pembelian</h4>
                <p class="card-category">Hingga {{ date('d, F Y H:i') }} WIB</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="mb-3 d-flex justify-content-between">
                        <form class="navbar-form w-19 ml-2 mt-1" action="{{route('staf.pembelian.cari')}}"
                            method="POST">
                            <div class="input-group no-border">
                                <input class="form-control" type="text" name="search" id="search"
                                    placeholder="Cari Nama Supplier...">
                                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                    <i class="material-icons">search</i>
                                    <div class="ripple-container"></div>
                                </button>
                                @csrf
                            </div>
                        </form>

                        <div class="mt-1 mr-3">
                            <a class="btn btn-white btn-round btn-just-icon" style="cursor: pointer;" title="Filter"
                                id="dropdownMember" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">
                                    filter_list
                                </i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMember">
                                <small class="text-rose ml-2">Filter Tanggal</small>
                                <form action="{{ route('staf.pembelian.cari') }}" method="post" id="target">
                                    <input class="dropdown-item dropdown-item-staf" type="text" name="datefilter"
                                        placeholder="Filter Tanggal ... " required autocomplete="off" />
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>

                    <table class="table" id="dataTables">
                        <thead class="text-dark">
                            <th>ID</th>
                            <th>Supplier</th>
                            <th>Nama Barang</th>
                            <th>Total</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            {{-- <th>Status</th> --}}
                            <th>Data Dibuat</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            <tr>
                                <td>{{$data->id}}</td>
                                <td>{{$data->supplier->nama_supplier}}</td>
                                <td>{{$data->nama_barang}}</td>
                                <td>{{$data->pcs}}</td>
                                <td>{{$data->harga_satuan }}</td>
                                <td>{{$data->total_harga}}</td>
                                {{-- <td>{{$data->status == 0 ? 'Produk Belum diupdate' : 'Sudah diupdate' }}</td> --}}
                                <td>{{$data->created_at}}</td>
                                <td>
                                    <span class="btn btn-just-icon btn-sm" data-toggle="dropdown" id="dropdown"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">
                                            more_vert
                                        </i>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown">
                                        <a href="{{route('pembelian.cetak', [$data->id])}}" class="nav-link">Cetak</a>

                                        {{-- <a href="#" class="nav-link">Ubah Status</a> --}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$datas->links()}}
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
