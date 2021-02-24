<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
        <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
                <i class="material-icons">recent_actors</i>
            </div>
            <p class="card-category">Member Aktif</p>
            <h3 class="card-title">
                {{$member}}
            </h3>
        </div>
        <div class="card-footer">
            <div class="stats">
                <i class="material-icons">update</i>Hingga Saat Ini
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
                <i class="fa fa-receipt" aria-hidden="true"></i>
            </div>
            <p class="card-category">Total Transaksi</p>
            <h3 class="card-title">{{$penjualan->count()}} </h3>
        </div>
        <div class="card-footer">
            <div class="stats">
                <i class="material-icons">date_range</i> Transaksi Sukses Hari Ini
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
        <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
                <i class="fa fa-money-bill" aria-hidden="true"></i>
            </div>
            <p class="card-category">Penjualan</p>
            <h3 class="card-title">Rp.{{number_format($penjualan->sum(), '0', ',', '.')}}</h3>
        </div>
        <div class="card-footer">
            <div class="stats">
                <i class="material-icons">date_range</i> Pendapatan Hari Ini
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
        <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon">
                <i class="fa fa-file-invoice-dollar" aria-hidden="true"></i>
            </div>
            <p class="card-category">Laba / Rugi</p>
            <h3 class="card-title">{{$pengeluaran}}</h3>
        </div>
        <div class="card-footer">
            <div class="stats">
                <i class="material-icons">receipt_long</i> Bulan Ini
            </div>
        </div>
    </div>
</div>
