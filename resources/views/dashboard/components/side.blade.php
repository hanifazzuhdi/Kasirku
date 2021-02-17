<div class="sidebar" data-color="orange" data-background-color="black"
    data-image="{{asset('backend/assets/img/sidebar-1.jpg')}}">
    <div class="logo"><a href="#" class="simple-text logo-normal">
            KASIR
        </a></div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{request()->is('dashboard') ? ' active' : ''}}">
                <a class="nav-link" href="{{route('home')}}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{asset('backend/examples/user.html')}}">
                    <i class="material-icons">person</i>
                    <p>Laporan</p>
                </a>
            </li>
            <li class="nav-item{{request()->is('admin/daftar-member') ? ' active' : ''}}">
                <a class="nav-link" href="{{route('admin.member')}}">
                    <i class="material-icons">content_paste</i>
                    <p>Member</p>
                </a>
            </li>
            <li class="nav-item{{request()->is('admin/daftar-karyawan') ? ' active' : ''}}">
                <a class="nav-link" href="{{route('admin.karyawan')}}">
                    <i class="material-icons">library_books</i>
                    <p>Karyawan</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{asset('backend/examples/map.html')}}">
                    <i class="material-icons">location_ons</i>
                    <p>Supplier</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{asset('backend/examples/icons.html')}}">
                    <i class="material-icons">bubble_chart</i>
                    <p>Produk</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{asset('backend/examples/notifications.html')}}">
                    <i class="material-icons">notifications</i>
                    <p>Pengeluaran</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{asset('backend/examples/notifications.html')}}">
                    <i class="material-icons">notifications</i>
                    <p>Aktivitas Karyawan</p>
                </a>
            </li>
            <li class="nav-item active-pro ">
                <a class="nav-link" href="{{asset('backend/examples/upgrade.html')}}">
                    <p>User Logged In</p>
                    <p> {{ Str::upper( Auth::user()->nama ) }} </p>
                </a>
            </li>
        </ul>
    </div>
</div>
