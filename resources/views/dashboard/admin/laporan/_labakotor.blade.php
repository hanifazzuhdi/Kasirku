<h5 class="font-weight-bold">Penghitungan Laba Kotor : </h5>
<div class="ml-4">
    <div class="row">
        <div class="col-3">
            <p>Pembelian Bulanan </p>
        </div>
        <div class="col-1">:</div>
        Rp.{{number_format($pembelian,'0', ',','.')}},-
    </div>
    <div class="row">
        <div class="col-3">
            <p class="d-inline mr-5">Laba Kotor </p>
        </div>
        <div class="col-1">
            :
        </div>
        <div>
            <span class="d-block font-weight-bold"> Rp.{{number_format($pembelian, '0',',','.')}} </span>
            <span class="border-bottom my-2 pb-2 d-block"> Rp.{{number_format($penjualan, '0',',','.')}} ( -
                )</span>
            <span class="font-weight-bold">Rp.{{ number_format($labaKotor, '0', ',', '.')}},- </span>
        </div>
    </div>
</div>
