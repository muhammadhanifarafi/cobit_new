<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->level == 1)
            <li class="header">MASTER</li>
            <li>
                <a href="{{ route('permintaan_pengembangan.index') }}">
                    <i class="fa fa-envelope-o"></i> <span>Permintaan Pengembangan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('persetujuan_pengembangan.index') }}">
                    <i class="fa fa-check-square-o"></i> <span>Persetujuan Pengembangan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('perencanaan_proyek.index') }}">
                    <i class="fa fa-map-o"></i> <span>Perencanaan Proyek</span>
                </a>
            </li>
            <li>
                <a href="{{ route('perencanaan_kebutuhan.index') }}">
                    <i class="fa fa-book"></i> <span>Perencanaan Kebutuhan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('analisis_desain.index') }}">
                    <i class="fa fa-clone"></i> <span>Analisis & Desain</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user_acceptance_testing.index') }}">
                    <i class="fa fa-pencil-square-o"></i> <span>User Acceptance Testing</span>
                </a>
            </li>
            <li>
                <a href="{{ route('quality_assurance_testing.index') }}">
                    <i class="fa fa-pencil-square-o"></i> <span>Quality Assurance Testing</span>
                </a>
            </li>
            <li>
                <a href="{{ route('serah_terima_aplikasi.index') }}">
                    <i class="fa fa-handshake-o"></i> <span>Berita Acara Serah Terima</span>
                </a>
            </li>
            {{-- <li class="header">TRANSAKSI</li>
            <li>
                <a href="{{ route('pengeluaran.index') }}">
                    <i class="fa fa-money"></i> <span>Pengeluaran</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pembelian.index') }}">
                    <i class="fa fa-download"></i> <span>Pembelian</span>
                </a>
            </li>
            <li>
                <a href="{{ route('penjualan.index') }}">
                    <i class="fa fa-upload"></i> <span>Penjualan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi.index') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Aktif</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi.baru') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Baru</span>
                </a>
            </li>
            <li class="header">REPORT</li>
            <li>
                <a href="{{ route('laporan.index') }}">
                    <i class="fa fa-file-pdf-o"></i> <span>Laporan</span>
                </a>
            </li> --}}
            <li class="header">SYSTEM</li>
            <li>
                <a href="{{ route('user.index') }}">
                    <i class="fa fa-users"></i> <span>User</span>
                </a>
            </li>
            <li>
                <a href="{{ route("setting.index") }}">
                    <i class="fa fa-cogs"></i> <span>Pengaturan</span>
                </a>
            </li>
            @else
            <li>
                <a href="{{ route('transaksi.index') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Aktif</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi.baru') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Baru</span>
                </a>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
