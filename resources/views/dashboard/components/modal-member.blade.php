<!-- Modal -->
<div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="p-4 text-center border">
                        <img width="120" height="120" id="qr_code" src="{{$datas[0]->qr_code}}" alt="QR Code">

                        <h3 class="mt-3 font-weight-bold" id="kode_member">000999981907</h3>
                    </div>
                    <div class="border p-4 mt-1">
                        <div class="container">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Nama : </label>
                                        <br>
                                        <input id="nama" class="form-control" type="text" value="Hanif" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Nomor : </label>
                                        <br>
                                        <input id="nomor" class="form-control" type="text" value="08999981907" disabled>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-4">
                                        <label for="">Status : </label>
                                        <br>
                                        <input id="status" class="form-control" type="text" value="Aktif" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Created At : </label>
                                        <br>
                                        <input id="created_at" class="form-control" type="text" value="Aktif" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Updated At : </label>
                                        <br>
                                        <input id="updated_at" class="form-control" type="text" value="Aktif" disabled>
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
