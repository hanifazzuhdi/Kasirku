<div class="col-6 p-4 border shadow-sm">

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

</div>

<div class="d-grid gap-2 col-5">
    <button class="btn btn-outline-primary" id="transaksi" data-url="{{route('bayar.cash')}}">Proses
        Transaksi</button>
    <button class="btn btn-outline-info" id="member" data-url="{{route('bayar.saldo')}}">Bayar Dengan
        Saldo
        (Member)</button>
    <button class="btn btn-outline-danger" id="cancel" data-url="{{route('transaksi.cancel')}}">Cancel</button>
    <button class="btn btn-primary" type="button" name="belumSelesai">
        Transaksi Belum Selesai
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#topup">
        TopUp Saldo
    </button>
</div>


<div class="invisible">
    <form action='/cetak-penjualan' method="POST">
        <button type="submit">Cetak</button>
        @csrf
    </form>
</div>


@include('dashboard.kasir._modal-topup')
