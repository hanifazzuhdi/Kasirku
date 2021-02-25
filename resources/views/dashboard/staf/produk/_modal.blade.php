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
                    </div>
                    <div class="border p-4 mt-1">
                        <div class="container">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for=""><span class="text-danger"> * </span> Nama Produk : </label>
                                            <br>
                                            <input name="nama_produk" id="nama" class="form-control" type="text"
                                                value="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for=""> <span class="text-danger"> * </span> Stok : </label>
                                            <br>
                                            <input name="stok" id="stok" class="form-control" type="text" value="">
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
                                            <label for=""> <span class="text-danger"> * </span> Harga Beli : </label>
                                            <br>
                                            <input name="harga_beli" id="harga_beli" class="form-control" type="text"
                                                value="">
                                        </div>
                                        <div class="col-md-4">
                                            <label for=""> <span class="text-danger"> * </span> Harga Jual : </label>
                                            <br>
                                            <input name="harga_jual" id="harga_jual" class="form-control" type="text"
                                                value="">
                                        </div>
                                        <div class="col-md-4">
                                            <label for=""> <span class="text-danger"> * </span> Diskon Member : </label>
                                            <br>
                                            <input name="diskon" id="diskon" class="form-control" type="text" value="">
                                        </div>
                                    </div>
                                </div>
                                @csrf
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mr-3">
                <button type="button" class="btn btn-black" data-dismiss="modal">Close</button>
                <button onclick="return confirm('Yakin Update Produk ?')" type="submit"
                    class="btn btn-warning">Update</button>
                </form>
            </div>

        </div>
    </div>
</div>
