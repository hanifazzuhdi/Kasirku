<div class="sidebar" data-color="orange" data-background-color="black"
    data-image="{{asset('backend/assets/img/sidebar-1.jpg')}}">
    <div class="logo">
        <a href="#" class="simple-text logo-normal">
            KASIR
        </a>
    </div>

    @if (Auth::user()->role_id == 1)
    <div class="sidebar-wrapper">
        @include('dashboard.components._side-admin')
    </div>
    @endif

</div>
