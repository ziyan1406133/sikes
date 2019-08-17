
@if(auth()->user()->role == 'Admin')
    <li class="dropdown dropdown-mm">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Data Keuangan 
                @if(count($nav_tolak) > 0)
                    <span class="badge">{{count($nav_tolak)}}</span>
                @endif
            <b class="caret"></b>
        </a>
        <!-- Dropdown Menu -->
        <ul class="dropdown-menu dropdown-menu-mm dropdown-menu-persist">
            <li class="row">
                <ul class="col-md-6">
                    <li class="dropdown-header">Pemasukan</li>
                    <li><a href="/tagihan">SPP</a></li>
                    <li><a href="/BOS">Bantuan Operasional Sekolah</a></li>
                    <li><a href="/pemasukanlain">Lainnya</a></li>
                </ul>
                <ul class="col-md-6">
                    <li class="dropdown-header">Pengeluaran</li>
                    <li><a href="/pengeluaranrutin">Rutin</a></li>
                    <li><a href="/pengeluarannonrutin">Non Rutin 
                            @if(count($nav_tolak) > 0)
                                <span class="badge">{{count($nav_tolak)}}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu Admin<b class="caret"></b></a>
        <!-- Dropdown Menu -->
        <ul class="dropdown-menu">
            <li><a href="/user" tabindex="-1" class="menu-item">Daftar Siswa</a></li>
            <li><a href="/user/2" tabindex="-1" class="menu-item">Profil Kepala Sekolah</a></li>
            <li><a href="/user/3" tabindex="-1" class="menu-item">Profil Bendahara</a></li>
            <li><a href="/kelas" tabindex="-1" class="menu-item">Daftar Kelas</a></li>
            <li><a href="/tahunajaran" tabindex="-1" class="menu-item">Tahun Ajaran</a></li>
            <li><a href="/jenisk" tabindex="-1" class="menu-item">Jenis Pengeluaran</a></li>
            <li><a href="/jenist" tabindex="-1" class="menu-item">Jenis Tagihan Siswa</a></li>
        </ul>
    </li>
@elseif(auth()->user()->role == 'Siswa')
    <li><a href="/tagihan/{{auth()->user()->id}}">Informasi</a></li>
@elseif((auth()->user()->role == 'Kepala Sekolah') || (auth()->user()->role == 'Bendahara'))
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan<b class="caret"></b></a>
        <!-- Dropdown Menu -->
        <ul class="dropdown-menu">
            <li><a href="/laporanspp" tabindex="-1" class="menu-item">SPP</a></li>
            <li><a href="/laporanmasuk" tabindex="-1" class="menu-item">Pemasukan</a></li>
            <li><a href="/laporanrutin" tabindex="-1" class="menu-item">Pengeluaran Rutin</a></li>
            <li><a href="/laporankeluar" tabindex="-1" class="menu-item">Pengeluaran Non Rutin</a></li>
        </ul>
    </li>
    @if(auth()->user()->role == 'Kepala Sekolah')
        <li><a href="/pengeluarannonrutin">Pengeluaran Non Rutin 
            @if(count($nav_pending) > 0)
                <span class="badge">{{count($nav_pending)}}</span>
            @endif</a>
        </li>
    @endif
@endif