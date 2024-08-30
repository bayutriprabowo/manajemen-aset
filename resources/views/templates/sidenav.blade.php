<!-- layout nav-->
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Menu</div>

                <a class="nav-link collapsed {{ request()->routeIs('users.index', 'items.index', 'item_types.index', 'item_statuses.index', 'vendors.index', 'companies.index', 'departments.index') ? '' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="{{ request()->routeIs('users.index', 'items.index', 'item_types.index', 'item_statuses.index', 'vendors.index', 'companies.index', 'departments.index') ? 'true' : 'false' }}"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Master Data
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('users.index', 'items.index', 'item_types.index', 'item_statuses.index', 'vendors.index', 'companies.index', 'departments.index') ? 'show' : '' }}"
                    id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @if (auth()->user()->masterRole->name == 'superuser')
                            <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">Master User</a>
                        @endif
                        @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                            <a class="nav-link {{ request()->routeIs('items.index') ? 'active' : '' }}"
                                href="{{ route('items.index') }}">Master Item</a>
                        @endif
                        @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                            <a class="nav-link {{ request()->routeIs('item_types.index') ? 'active' : '' }}"
                                href="{{ route('item_types.index') }}">Master Tipe Item</a>
                        @endif
                        @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                            <a class="nav-link {{ request()->routeIs('item_statuses.index') ? 'active' : '' }}"
                                href="{{ route('item_statuses.index') }}">Master Status/Kondisi Item</a>
                        @endif
                        @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                            <a class="nav-link {{ request()->routeIs('vendors.index') ? 'active' : '' }}"
                                href="{{ route('vendors.index') }}">Master Vendor</a>
                        @endif
                        @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                            <a class="nav-link {{ request()->routeIs('companies.index') ? 'active' : '' }}"
                                href="{{ route('companies.index') }}">Master Perusahaan</a>
                        @endif
                        @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                            <a class="nav-link {{ request()->routeIs('departments.index') ? 'active' : '' }}"
                                href="{{ route('departments.index') }}">Master Departemen</a>
                        @endif
                    </nav>
                </div>

                <a class="nav-link collapsed {{ request()->routeIs('procurements.index', 'incoming_items.index', 'outgoing_items.index', 'movements.index', 'stocks.index', 'monitorings.index', 'depreciations.index') ? '' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2"
                    aria-expanded="{{ request()->routeIs('procurements.index', 'incoming_items.index', 'outgoing_items.index', 'movements.index', 'stocks.index', 'monitorings.index', 'depreciations.index') ? 'true' : 'false' }}"
                    aria-controls="collapseLayouts2">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Transaction
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('procurements.index', 'incoming_items.index', 'outgoing_items.index', 'movements.index', 'stocks.index', 'monitorings.index', 'depreciations.index') ? 'show' : '' }}"
                    id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('procurements.index') ? 'active' : '' }}"
                            href="{{ route('procurements.index') }}">Pengadaan</a>
                        <a class="nav-link {{ request()->routeIs('incoming_items.index') ? 'active' : '' }}"
                            href="{{ route('incoming_items.index') }}">Barang Masuk</a>
                        <a class="nav-link {{ request()->routeIs('outgoing_items.index') ? 'active' : '' }}"
                            href="{{ route('outgoing_items.index') }}">Barang Keluar</a>
                        <a class="nav-link {{ request()->routeIs('movements.index') ? 'active' : '' }}"
                            href="{{ route('movements.index') }}">Mutasi Barang</a>
                        <a class="nav-link {{ request()->routeIs('stocks.index') ? 'active' : '' }}"
                            href="{{ route('stocks.index') }}">Stok Barang</a>
                        <a class="nav-link {{ request()->routeIs('monitorings.index') ? 'active' : '' }}"
                            href="{{ route('monitorings.index') }}">Monitoring Barang</a>
                        <a class="nav-link {{ request()->routeIs('depreciations.index') ? 'active' : '' }}"
                            href="{{ route('depreciations.index') }}">Penyusutan Barang</a>
                    </nav>
                </div>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->name }} / {{ auth()->user()->masterRole->name }}
        </div>
    </nav>
</div>
<!-- end layout nav -->
