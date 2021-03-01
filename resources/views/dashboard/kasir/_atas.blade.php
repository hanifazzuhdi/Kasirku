{{-- Info --}}
<div class="col-4 py-3 border shadow-sm">
    <div class="row mb-3">
        <label for="tanggal" class="col-sm-2 col-form-label col-form-label-sm">Tanggal</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="tanggal" value="{{date('d F Y')}}" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <label for="kasir" class="col-sm-2 col-form-label col-form-label-sm">Kasir</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="kasir" value="{{Auth::user()->nama}}" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <label for="member" class="col-sm-2 col-form-label col-form-label-sm">Member</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="kode_member"
                placeholder="Masukkan Kode Member (Opsional)">
        </div>
    </div>
</div>

{{-- Add --}}
<div class="col-3 border py-3">
    <div class="input-group mb-3">

        <span class="input-group-text" id="basic-addon1">
            <small> UID </small>
        </span>

        <select required name="uid" type="text" class="form-control" placeholder="Masukkan UID Barang"
            aria-describedby=" basic-addon1">
            <option></option>
            @foreach ($produks as $item)
            <option value="{{$item->uid}}">{{$item->uid}}</option>
            @endforeach
        </select>
    </div>

    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
            <i class="material-icons">
                add_shopping_cart
            </i>
        </span>
        <input required name="pcs" type="text" class="form-control" placeholder="Jumlah"
            aria-describedby=" basic-addon1">
    </div>

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-sm btn-secondary tambah">Tambah</button>
    </div>
</div>

{{-- Tagihan --}}
<div class="col-4 p-5 border shadow bg-danger bg-gradien text-white">
    <h3 class="text-center pt-3"> Tagihan : <span class="tagihan"> 0 </span> </h3>
</div>
