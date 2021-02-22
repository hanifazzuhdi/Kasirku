<!-- Modal -->
<div class="modal fade" id="modalSupplier" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('staf.pembelian.addSupplier')}}" method="post">
                    <label class="text-dark">Nama Supplier : </label>
                    <input autocomplete="off" name="nama_supplier" class="form-control" type="text">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Tambah</button>
                @csrf
                </form>
            </div>
        </div>
    </div>
</div>
