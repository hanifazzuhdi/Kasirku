<li class="nav-item{{request()->is('dashboard/staff') ? ' active' : ''}}">
    <a class="nav-link" href="{{route('staf')}}">
        <i class="material-icons">dashboard</i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item{{request()->is('staff/daftar-pembelian') ? ' active' : ''}}">
    <a class="nav-link" href="{{route('staf.pembelian')}}">
        <i class="material-icons">receipt_long</i>
        <p>Pembelian</p>
    </a>
</li>

<li class="nav-item{{request()->is('staff/tambah-pembelian') ? ' active' : ''}}">
    <a class="nav-link" href="{{route('staf.pembelian.create')}}">
        <i class="material-icons">shop_two</i>
        <p>Tambah Pembelian</p>
    </a>
</li>

<li class="nav-item{{request()->is('staff/daftar-produk') ? ' active' : ''}}">
    <a class="nav-link" href="{{route('staf.produk')}}">
        <i class="material-icons">bubble_chart</i>
        <p>Daftar Produk</p>
    </a>
</li>
