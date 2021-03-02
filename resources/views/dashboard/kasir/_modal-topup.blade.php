<!-- Modal -->
<div class="modal fade" id="topup" tabindex="-1" aria-labelledby="topupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="topupLabel">TopUp Saldo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Kode Member" aria-label="Kode Member"
                        aria-describedby="kodeMember" name="kode_member">
                    <button class="btn btn-outline-secondary" type="button" id="kodeMember">Cari Member</button>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control d-block" placeholder="Nominal Top Up"
                        aria-label="Kode Member" aria-describedby="kodeMember" name="nominal">
                </div>

                <div id="detail_member"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" name="topup">Top Up</button>
            </div>
        </div>
    </div>
</div>
