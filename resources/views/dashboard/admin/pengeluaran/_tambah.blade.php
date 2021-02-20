<div class="pb-2 card-header border-bottom d-flex justify-content-between bg-light">
    <h5>Tambah Data Pengeluaran</h5>
    <a href="#collapseCard" data-toggle="collapse" role="button">
        <span class="material-icons">
            keyboard_arrow_down
        </span>
    </a>
</div>

<div class="collapse" id="collapseCard">
    <div class="card-body mt-4">
        <form action="{{route('admin.pengeluaran.store')}}" method="post">
            <div class="form-group">
                <label for="">Nama Pengeluaran : </label>
                <input name="nama_pengeluaran" type="text" class="form-control">
            </div>

            <div class="form-group mt-4">
                <label for="">Total Pengeluaran : </label>
                <input name="jumlah" type="text" class="form-control">
            </div>

            <div class="form-group d-flex justify-content-end mt-3">
                <button class="btn btn-warning" type="submit">Submit</button>
            </div>
            @csrf
        </form>
    </div>
</div>
