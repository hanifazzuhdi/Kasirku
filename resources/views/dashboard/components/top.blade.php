<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="{{ Auth::user()->role_id == 1 ? '/dashboard/admin' : '/dashboard/staff'}}">
                @if ( explode('/', request()->path())[0] == 'dashboard' )
                <i class="material-icons pb-1">
                    home
                </i>
                Dashboard
                @else
                <i class="material-icons pb-2">
                    reply_all
                </i> Go to Dashboard
                @endif
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img class="bg-light rounded-circle p-1" src="{{Auth::user()->avatar}}" width="35px"
                            alt="Avatar">
                        <span class="pt-3"> {{Auth::user()->nama}} </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        @if (Auth::user()->role_id == 1)
                        <a class="nav-link" href="{{route('admin.settings')}}">Settings</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form class="d-flex justify-content-center py-2" action="{{route('logout')}}" method="post">
                            @if (Auth::user()->role_id != 1)
                            <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                                data-target="#modelId">
                                Akhiri Sesi
                            </button>
                            @else
                            <button class="btn btn-light btn-sm" type="submit">Log out</button>
                            @endif
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

@include('dashboard.components._logout')
