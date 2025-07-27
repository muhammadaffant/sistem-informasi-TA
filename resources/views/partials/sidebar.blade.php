<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            <li>
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            @if (auth::user()->hasRole('admin'))
                <li>
                    <a href="{{ route('admin.layanan.index') }}" class="nav-link"><i
                            class="fas fa-concierge-bell"></i><span>Data
                            Layanan</span></a>
                </li>

                <li>
                    <a href="{{ route('admin.brands.index') }}" class="nav-link"><i class="fas fa-tags"></i><span>Data
                            Brand</span></a>
                </li>

                <li>
                    <a href="{{ route('admin.bahan.index') }}" class="nav-link"><i class="fas fa-tags"></i><span>Data
                            Bahan</span></a>
                </li>
                <li class="menu-header">Data Master</li>
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

                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-shopping-cart"></i>
                        <span>Manajemen Order</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.customorders.index') }}">Custom Order</a></li>
                        <li><a class="nav-link" href="{{ route('admin.orders.index') }}">Order</a></li>
                    </ul>
                </li>
            @endif

            @if (auth::user()->hasRole('owner'))
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-shopping-cart"></i>
                        <span>Manajemen Order</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.customorders.index') }}">Custom Order</a></li>
                        <li><a class="nav-link" href="{{ route('owner.orders.index') }}">Order</a></li>
                    </ul>
                </li>
            @endif

        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
