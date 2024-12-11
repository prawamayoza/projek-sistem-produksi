<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand" style="padding-bottom: 20px;"> <!-- Menambahkan padding bawah -->
            <a href="home">
                <img src="{{asset('/assets/img/logo.png')}}" alt="logo" class="main-logo">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">
                <img src="{{asset('/assets/img/logo-circle.png')}}" alt="logo" class="small-logo">
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

                <li class="nav-item {{ request()->is('projek*') ? 'active' : '' }}">
                    <a href="{{ route('projek.index') }}" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span>A. Project</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('task*') ? 'active' : '' }}">
                    <a href="{{ route('task.index') }}" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span>A. Tasklist</span>
                    </a>
                </li>
            @endrole

            @role('peg.produksi')
            <li class="nav-item {{ request()->is('projek*') ? 'active' : '' }}">
                <a href="{{ route('projek.index') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Peg. Project</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('task*') ? 'active' : '' }}">
                <a href="{{ route('task.index') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Peg. Tasklist</span>
                </a>
            </li>
            @endrole

            @role('c.level')
            <li class="nav-item {{ request()->is('projek*') ? 'active' : '' }}">
                <a href="{{ route('projek.index') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>C. Projek</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('task*') ? 'active' : '' }}">
                <a href="{{ route('task.index') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>C. Tasklist</span>
                </a>
            </li>

            @endrole
            <li class="nav-item {{ request()->is('history*') ? 'active' : '' }}">
                <a href="{{ route('history.index') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Aktivitas User</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
