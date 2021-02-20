<div class="sidebar" data-color="{{ Auth::user()->role_id == 1 ? 'orange' : 'azure'}}"
    data-background-color="{{ Auth::user()->role_id == 1 ?'black' : 'white'}}"
    data-image="{{asset('backend/assets/img/sidebar-4.jpg')}}">
    <div class="logo">
        <a href="#" class="simple-text logo-normal">
            KASIR
        </a>
    </div>

    <div class="sidebar-wrapper">
        <ul class="nav">
            @if (Auth::user()->role_id == 1)
            @include('dashboard.components._side-admin')
            @endif

            @if (Auth::user()->role_id == 2)
            @include('dashboard.components._side-staf')
            @endif

            <li class="nav-item active-pro ">
                <a class="nav-link" href="{{asset('backend/examples/upgrade.html')}}">
                    <p>SELAMAT SIANG</p>
                    <p> {{ Str::upper( Auth::user()->nama ) }} !</p>
                </a>
            </li>
        </ul>
    </div>

</div>
