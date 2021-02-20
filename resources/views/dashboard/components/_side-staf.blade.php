<li class="nav-item{{request()->is('dashboard/staf') ? ' active' : ''}}">
    <a class="nav-link" href="{{route('home')}}">
        <i class="material-icons">dashboard</i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item{{request()->is('dashboard') ? ' active' : ''}}">
    <a class="nav-link" href="{{route('home')}}">
        <i class="material-icons">dashboard</i>
        <p>Pembelian</p>
    </a>
</li>
<li class="nav-item{{request()->is('dashboard') ? ' active' : ''}}">
    <a class="nav-link" href="{{route('home')}}">
        <i class="material-icons">dashboard</i>
        <p>Barang</p>
    </a>
</li>
