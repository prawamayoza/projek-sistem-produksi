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
        </ul>
    </aside>
</div>
