<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h4> SELAMAT {{Str::upper($sapa)}} {{Str::upper(Auth::user()->nama)}}, SEMANGAT BEKERJA ! </h4>
            </div>
            <div class="modal-footer">
                <button onclick="openFullscreen()" type="button" data-bs-dismiss="modal"
                    class="btn btn-primary mulai">Mulai Kerja</button>
            </div>
        </div>
    </div>
</div>
