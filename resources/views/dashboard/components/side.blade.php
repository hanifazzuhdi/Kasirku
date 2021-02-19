<div class="sidebar" data-color="orange" data-background-color="white"
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
                    <i class="material-icons">library_books</i>
                    <p>Laporan</p>
                </a>
            </li>
            <li class="nav-item{{request()->is('admin/daftar-member') ? ' active' : ''}}">
                <a class="nav-link" href="{{route('admin.member')}}">
                    <i class="material-icons">people</i>
                    <p>Member</p>
                </a>
            </li>
            <li class="nav-item{{request()->is('admin/daftar-karyawan') ? ' active' : ''}}">
                <a class="nav-link" href="{{route('admin.karyawan')}}">
                    <i class="material-icons">assignment_ind</i>
                    <p>Karyawan</p>
                </a>
            </li>
            <li class="nav-item{{request()->is('admin/daftar-supplier') ? ' active' : ''}}">
                <a class="nav-link" href="{{route('admin.supplier')}}">
                    <i class="material-icons">local_shipping</i>
                    <p>Supplier</p>
                </a>
            </li>
            <li class="nav-item{{request()->is('admin/daftar-produk') ? ' active' : ''}}">
                <a class="nav-link" href="{{route('admin.produk')}}">
                    <i class="material-icons">bubble_chart</i>
                    <p>Produk</p>
                </a>
            </li>
            <li class="nav-item{{request()->is('admin/pengeluaran') ? ' active' : ''}}">
                <a class="nav-link" href="{{route('admin.pengeluaran')}}">
                    <i class="material-icons">payments</i>
                    <p>Pengeluaran</p>
                </a>
            </li>
            <li class="nav-item{{request()->is('admin/aktivitas-karyawan') ? ' active' : ''}}">
                <a class="nav-link" href="{{route('admin.aktivitas')}}">
                    <i class="material-icons">notifications</i>
                    <p>Aktivitas Karyawan</p>
                </a>
            </li>

            <li class="nav-item active-pro ">
                <a class="nav-link" href="{{asset('backend/examples/upgrade.html')}}">
                    <p>SELAMAT SIANG</p>
                    <p> {{ Str::upper( Auth::user()->nama ) }} !</p>
                </a>
            </li>
        </ul>
    </div>
</div>
