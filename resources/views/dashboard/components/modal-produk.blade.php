<!-- Modal -->
<div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="p-4 text-center border">
                        <img height="45px" id="barcode" src="" alt="Barcode">
                        {{-- <h3 class="mt-3 font-weight-bold" id="uid"></h3> --}}
                    </div>
                    <div class="border p-4 mt-1">
                        <div class="container">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Nama Produk : </label>
                                        <br>
                                        <input id="nama" class="form-control" type="text" value="" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Stok : </label>
                                        <br>
                                        <input id="stok" class="form-control" type="text" value="" disabled>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <label for="">Kategori : </label>
                                        <br>
                                        <input id="kategori" class="form-control" type="text" value="" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Merek : </label>
                                        <br>
                                        <input id="merek" class="form-control" type="text" value="" disabled>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label for="">Harga Beli : </label>
                                        <br>
                                        <input id="harga_beli" class="form-control" type="text" value="" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Harga Jual : </label>
                                        <br>
                                        <input id="harga_jual" class="form-control" type="text" value="" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Diskon Member : </label>
                                        <br>
                                        <input id="diskon" class="form-control" type="text" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <button type="button" class="btn btn-black" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger mr-3" type="submit">Banned</button>
                    @csrf
                    @method('delete')
                </form>
            </div>

        </div>
    </div>
</div>
