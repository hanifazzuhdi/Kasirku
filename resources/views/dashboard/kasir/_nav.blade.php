<nav class="navbar navbar-light border-bottom shadow-sm">

    <div class="container-fluid d-flex justify-content-between px-3 py-1 mx-5">
        <a class="navbar-brand" href="#">
            {{config('app.name')}}
        </a>

        <div id="clock" class="clock">loading ...</div>

        <form class="d-flex justify-content-center" action="{{route('logout')}}" method="post">
            <button class="btn btn-light btn-sm" type="submit">Log out</button>
            @csrf
        </form>

    </div>
</nav>
