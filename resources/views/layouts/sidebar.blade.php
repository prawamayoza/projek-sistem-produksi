<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="home">
                <span style="font-size: larger; font-weight: bold;">
                    SIMPROD
                </span>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">
            
            </a>
        </div>

        <ul class="sidebar-menu">
            @role('admin')
                <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>Master User</span>
                    </a>
                </li>

                {{-- <li class="nav-item {{ request()->is('home*') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span>Sales Performance</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('laporan-harian*') ? 'active' : '' }}"> 
                    <a href="{{ route('laporan-harian.index') }}" class="nav-link">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Jadwal Harian Teknisi</span>
                    </a>
                </li> --}}
            @endrole


            {{-- @role('cs')
                <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span></a>
                </li>

                <li class="{{ request()->is('jadwal*') ? 'active' : '' }}">
                    <a class="nav-link " href="{{ route('jadwal.index') }}">
                        <i class="fas fa-columns"></i>
                        <span>Kelola Jadwal</span>
                    </a>
                </li>

                <li class="{{ request()->is('tiket*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('tiket.index') }}">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Kelola Tiket</span>
                    </a>
                </li>

                <li class="{{ request()->is('tiket*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('tiket.index') }}">
                        <i class="fas fa-comment"></i>
                        <span>Kelola Pesan</span>
                    </a>
                </li>
            @endrole --}}

        </ul>
    </aside>
</div>
