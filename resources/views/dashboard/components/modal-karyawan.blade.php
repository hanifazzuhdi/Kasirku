<!-- Modal -->
<div class="modal fade" id="modal-karyawan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="p-4 text-center border">
                        <img class="border p-3 rounded-circle" width="120" height="120" id="avatar" src=""
                            alt="QR Code">

                        <h3 class="mt-3 font-weight-bold" id="email">00000000000</h3>
                        <p id="nama"></p>
                    </div>
                    <div class="border p-4 mt-1">
                        <div class="container">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Alamat : </label>
                                        <br>
                                        <input id="alamat" class="form-control" type="text" value="alamat" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Umur : </label>
                                        <br>
                                        <input id="umur" class="form-control" type="text" value="umur" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Status : </label>
                                        <br>
                                        <input id="status" class="form-control" type="text" value="Status" disabled>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-4">
                                        <label for="">Email Verifikasi : </label>
                                        <br>
                                        <input id="verified_at" class="form-control" type="text" value="Created At"
                                            disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Tanggal Bergabung : </label>
                                        <br>
                                        <input id="created_at" class="form-control" type="text" value="Created At"
                                            disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Terakhir diubah : </label>
                                        <br>
                                        <input id="updated_at" class="form-control" type="text" value="Updated At"
                                            disabled>
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
                    <button class="btn btn-danger mr-3" type="submit">Berhentikan</button>
                    @csrf
                    @method('delete')
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="p-4 text-center border">
                        <img class="border p-3 rounded-circle" width="120" height="120" id="avatar"
                            src="https://i.ibb.co/Smw9VXW/Pngtree-users-vector-3725294.png" alt="QR Code">

                    </div>
                    <div class="border p-4 mt-1">
                        <div class="container">
                            <div class="form-group">
                                <form action="{{route('admin.karyawan.store')}}" method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="nama">Nama : </label>
                                            <br>
                                            <input id="nama" class="form-control" type="text">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Email : </label>
                                            <br>
                                            <input id="email" class="form-control" type="text">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Alamat : </label>
                                            <br>
                                            <input id="alamat" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-4">
                                            <label for="">Umur : </label>
                                            <br>
                                            <input id="umur" class="form-control" type="text">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Password : </label>
                                            <br>
                                            <input id="password" class="form-control" type="text">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Jabatan : </label>
                                            <br>
                                            <select name="role_id" class="custom-select">
                                                <option value="2">Staf</option>
                                                <option value="3">Kasir</option>
                                            </select>
                                        </div>
                                    </div>
                                    @csrf
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-warning" type="submit">Create</button>
                </form>
            </div>

        </div>
    </div>
</div>
