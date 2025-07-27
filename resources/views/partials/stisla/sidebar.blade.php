<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">VIMS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">VMS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            @if (Auth::user()->hasRole('admin'))
                <li class="menu-header">Master Data</li>

                <li>
                    <a href="{{ route('admin.brands.index') }}" class="nav-link"><i class="fas fa-tags"></i><span>Data
                            Brand</span></a>
                </li>

                {{-- <li>
                    <a href="{{ route('admin.layanan.index') }}" class="nav-link"><i
                            class="fas fa-concierge-bell"></i><span>Data
                            Layanan</span></a>
                </li> --}}
                {{--  <li>
                    <a href="{{ route('admin.ongkir.index') }}" class="nav-link"><i
                            class="fas fa-concierge-bell"></i><span>Data
                            Ongkir</span></a>
                </li>  --}}
 

                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-th-list"></i>
                        <span>Manajemen Kategori</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.category.index') }}">Kategori</a></li>
                        <li><a class="nav-link" href="{{ route('admin.subcategory.index') }}">Sub Kategori</a></li>
                        <li><a class="nav-link" href="{{ route('admin.subsubcategory.index') }}">Sub Sub Kategori</a>
                        </li>
                    </ul>
                </li>


                <li><a class="nav-link" href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i>
                        <span>Manajemen
                            Produk</span></a></li>
                <li>
                    <a class="nav-link" href="{{ route('admin.slider.index') }}"><i class="fas fa-box"></i>
                        <span>Manajemen
                            Slider</span>
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="{{ route('admin.reviews.index') }}"><i class="fas fa-star"></i>
                        <span>Manajemen Ulasan</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-shopping-cart"></i>
                        <span>Manajemen Order</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.customorders.index') }}">Custom Order</a></li>
                        <li><a class="nav-link" href="{{ route('admin.orders.index') }}">Order</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="{{ route('admin.laporanpenjualan.index') }}" class="nav-link"><i
                            class="fas fa-chart-bar"></i><span>Laporan Penjualan</span></a>
                </li>
                <li>
                    <a href="{{ route('admin.laporancustomorder.index') }}" class="nav-link"><i
                            class="fas fa-chart-bar"></i><span>Laporan CustomOrder</span></a>
                </li>

                {{-- <li>
                    <a href="{{ route('admin.statistic.index') }}" class="nav-link"><i
                            class="fas fa-chart-bar"></i><span>Statistik Pendapatan</span></a>
                </li> --}}
                 <li class="menu-header">Master Data Custom Order</li>
                                 <li>
                    <a href="{{ route('admin.bahan.index') }}" class="nav-link"><i
                            class="fas fa-concierge-bell"></i><span>Data
                            Bahan</span></a>
                </li>

                <li>
                    <a href="{{ route('admin.size.index') }}" class="nav-link"><i
                            class="fas fa-concierge-bell"></i><span>Data
                            Size</span></a>
                </li>
                
                <li>
                    <a href="{{ route('admin.kategorisablon.index') }}" class="nav-link"><i
                        class="fas fa-concierge-bell"></i><span>Kategori
                            Sablon</span></a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.jenissablon.index') }}" class="nav-link"><i
                                    class="fas fa-concierge-bell"></i><span>Jenis
                                    Sablon</span></a>
                        </li>
                <li>
                    <a href="{{ route('admin.datausers.index') }}" class="nav-link"><i
                            class="fas fa-users"></i><span>Data User</span></a>
                </li>
            @endif

            @if (Auth::user()->hasRole('owner'))
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-shopping-cart"></i>
                        <span>Manajemen Order</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('owner.orders.index') }}">Order</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('owner.statistic.index') }}" class="nav-link"><i
                            class="fas fa-chart-bar"></i><span>Statistik Pendapatan</span></a>
                </li>
                <li>
                    <a href="{{ route('owner.laporanpenjualan.index') }}" class="nav-link"><i
                            class="fas fa-chart-bar"></i><span>Laporan Penjualan</span></a>
                </li>
                                <li>
                    <a href="{{ route('owner.laporancustomorder.index') }}" class="nav-link"><i
                            class="fas fa-chart-bar"></i><span>Laporan CustomOrder</span></a>
                </li>
                  <li class="menu-header">Master Data Custom</li>
            @endif

            <li>
                <a class="nav-link" href="#" onclick="document.querySelector('#form-logout').submit()">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    <form action="{{ route('logout') }}" method="post" id="form-logout">
                        @csrf
                    </form>
                </a>
            </li>

        </ul>

    </aside>
</div>
