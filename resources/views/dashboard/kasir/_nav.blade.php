<nav class="navbar navbar-light border-bottom shadow-sm">

    <div class="container-fluid d-flex justify-content-between px-3 py-1 mx-5">
        <a class="navbar-brand" href="#">
            {{config('app.name')}}
        </a>

        <div id="clock" class="clock">loading ...</div>

        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Akhiri Sesi
        </button>

    </div>
</nav>

<!-- Modal Logout-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="text-center"> Yakin mengakhiri sesi kerja Anda ? </h4>
                <p class="text-justify"> Segala hal yang anda lakukan ketika berkerja terekam dan wajib
                    dipertanggungjawabkan.</p>
            </div>
            <div class="modal-footer">
                <form class="d-flex justify-content-center" action="{{route('logout')}}" method="post">
                    <button type="button" class="btn btn-outline-dark me-2" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-secondary">Logout</button>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
