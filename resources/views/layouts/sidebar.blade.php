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
            <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            @role('admin')
                <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>Master User</span>
                    </a>
                </li>
                @endrole

                <li class="nav-item {{ request()->is('projek*') ? 'active' : '' }}">
                    <a href="{{ route('projek.index') }}" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span>A. Projek</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('task*') ? 'active' : '' }}">
                    <a href="{{ route('task.index') }}" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span>Tasklist</span>
                    </a>
                </li>



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
