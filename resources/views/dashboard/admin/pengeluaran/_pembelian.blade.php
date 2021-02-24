<div class="card">
    <div class="card-header border-bottom card-header-warning">
        <h4 class="card-title font-weight-bold">Pembelian Terakhir</h4>
        <p class="card-category"> Diperbarui {{ date('d F Y, H:i ') }} WIB</p>
    </div>

    @foreach ($pembelians as $pembelian)
    <div class="card-body list-group border-bottom">
        <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1">
                {{$pembelian->nama_pengeluaran}}
            </h6>
            <div>
                <small> {{$pembelian->updated_at}} </small>
            </div>
        </div>
        <h6 class="mb-1"> Pengeluaran : Rp. {{ number_format($pembelian->jumlah,'0',',','.')}}</h6>
    </div>
    @endforeach
    <div class="card-footer d-flex justify-content-end mr-4">
        <a href="{{route('admin.laporan.pengeluaran')}}"> See all </a>
    </div>
</div>
