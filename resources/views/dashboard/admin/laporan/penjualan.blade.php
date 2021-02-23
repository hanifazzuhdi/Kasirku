@extends('layouts.master')

@section('content')

<h3 class="font-weight-bold mt-0 mb-4">Laporan Penjualan</h3>

<form id="target" action="{{route('admin.penjualan.cari')}}" method="post">
    <div class="d-flex justify-content-between px-2">
        <div class="input-group no-border">
            <input class="form-control" type="text" name="search" id="search" placeholder="Cari Nama Kasir...">
            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                <i class="material-icons">search</i>
                <div class="ripple-container"></div>
            </button>
        </div>

        <div class="w-25 selector" title="Filter Tanggal">
            <input class="form-control rounded" id="daterange"
                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%"
                name="datefilter">
        </div>
    </div>
    @csrf
</form>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-warning d-flex justify-content-between">
                <h4 class="card-title font-weight-bold font-weight-bold mt-0">Laporan Transaksi Penjualan</h4>

                <a href="{{route('admin.penjualan.export')}}"
                    class="btn btn-just-icon btn-sm text-dark mr-2 bg-light selector" title="Export to Excel">
                    <i class="material-icons">sim_card_download</i>
                </a>
            </div>
            <div class="card-body mt-3">
                <div class="table-responsive">
                    <table class="table" id="dataTables">
                        <thead class="text-dark">
                            <th>ID</th>
                            <th>Harga Total</th>
                            <th>Dibayar</th>
                            <th>Kembalian</th>
                            <th>Kode Member</th>
                            <th>Kasir</th>
                            <th>Tgl Transaksi</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            <tr>
                                <td> {{$data->id}} </td>
                                <td> Rp. {{number_format($data->harga_total, '0', ',', '.')}} </td>
                                <td> Rp. {{number_format($data->dibayar, '0', ',', '.')}} </td>
                                <td> Rp. {{number_format($data->kembalian, '0', ',', '.')}} </td>
                                <td> {{$data->kode_member}} </td>
                                <td> {{$data->kasir->nama}} </td>
                                <td> {{$data->created_at}} </td>
                                <td>
                                    <span class="btn btn-just-icon btn-sm" data-toggle="dropdown" id="dropdown"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">
                                            more_vert
                                        </i>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown">
                                        <a href="{{route('admin.penjualan.cetak', [$data->id])}}"
                                            class="nav-link text-dark">Cetak</a>
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
<script type="text/javascript">
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#daterange').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#daterange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        let myForm = $("#target");

        $('.ranges ul li').click(function (){

            let data = $(this).data('range-key');
            console.log(data);

            if (data != 'Custom Range'){
                setTimeout(function () {
                    myForm.submit();
                }, 10);
            }
        });

        $(".applyBtn").click(function(){
            setTimeout(function () {
                myForm.submit();
            }, 10);
        });

        $( ".selector" ).tooltip({ show: { effect: 'none', duration: 0 } });

    });
</script>
@endsection
