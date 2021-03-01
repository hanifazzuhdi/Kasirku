{{-- <div class="col-4 d-flex align-items-center">
    <div class="btn-group-vertical">
        <button class="btn btn-outline-primary py-3" id="transaksi" data-url="{{route('bayar.cash')}}">Transaksi Belum
Selesai</button>
<button class="btn btn-outline-info py-3" id="member" data-url="{{route('bayar.saldo')}}">Top Up Member</button>
</div>
</div> --}}

<div class="col-6 py-3 border shadow-sm">

    <div class="row mb-3">
        <label for="tanggal" class="col-sm-2 col-form-label col-form-label-sm">Total </label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm total" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <label for="kasir" class="col-sm-2 col-form-label col-form-label-sm">Diskon</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm diskon" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <label for="member" class="col-sm-2 col-form-label col-form-label-sm">Tagihan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm tagihan" disabled>
            <input type="hidden" class="form-control form-control-sm tagihanHidden" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <label for="member" class="col-sm-2 col-form-label col-form-label-sm">Bayar (Cash) </label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm bayar">
        </div>
    </div>

    <div class="row mb-4">
        <label for="member" class="col-sm-2 col-form-label col-form-label-sm">Kembali</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm kembalian" disabled>
        </div>
    </div>

    <div class="d-flex  justify-content-end">
        <button class="btn btn-outline-primary py-2" id="transaksi" data-url="{{route('bayar.cash')}}">Proses
            Transaksi</button>
        <button class="btn btn-outline-info py-2" id="member" data-url="{{route('bayar.saldo')}}">Bayar Dengan
            Saldo
            (Member)</button>
        <button class="btn btn-outline-danger py-2" id="cancel" data-url="{{route('transaksi.cancel')}}">Cancel</button>
    </div>

</div>
