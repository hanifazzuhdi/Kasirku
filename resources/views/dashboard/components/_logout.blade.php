<!-- Modal Logout-->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center font-weight-bold"> Yakin mengakhiri sesi kerja Anda ? </h4>
                <p class="text-justify"> Segala hal yang anda lakukan ketika berkerja terekam dan wajib
                    dipertanggungjawabkan.</p>
            </div>
            <div class="modal-footer">
                <form class="d-flex justify-content-center" action="{{route('logout')}}" method="post">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-light">Logout</button>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
