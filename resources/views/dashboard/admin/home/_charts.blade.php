<div class="col-md-6">
    <div class="card card-chart">
        <div class="card-header card-header-success">
            <canvas class="ct-chart" id="myAreaChart"></canvas>
        </div>
        <div class="card-body">
            <h4 class="card-title">Penghasilan Satu Minggu</h4>

        </div>
        <div class="card-footer">
            <div class="stats">
                <i class="material-icons">access_time</i> Hingga {{date('d, F Y H:i')}} WIB
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card card-chart">
        <div class="card-header card-header-info">
            <canvas class="ct-chart" id="bulanan"></canvas>
        </div>
        <div class="card-body">
            <h4 class="card-title">Laba / Rugi Perusahaan </h4>
        </div>
        <div class="card-footer">
            <div class="stats">
                <i class="material-icons">access_time</i>Hingga Bulan {{date('F Y')}}
            </div>
        </div>
    </div>
</div>
