<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ url('admin/dashboard') }}" class="navbar-brand mx-4 mb-3 d-flex align-items-center">
            <img src="{{ asset('image/Urkl.png') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
            <h3 class="text-primary mb-0">PSU <span class="text-gold">ACC</span></h3>
        </a>

        <div class="navbar-nav w-100">
            <!-- Dashboard -->
            <a href="{{ url('admin/dashboard') }}" class="nav-item nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <!-- Reports Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ Request::is('reports*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-chart-line me-2"></i>Reports
                </a>
                <ul class="dropdown-menu bg-light shadow-sm border-0 rounded">
                    <li>
                        <a href="{{ url('reports') }}" class="dropdown-item {{ Request::is('reports') ? 'active' : '' }}">
                            <i class="fa fa-calendar-day me-2"></i>Annually
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('reports_bi_quarterly') }}" class="dropdown-item {{ Request::is('reports_bi_quarterly') ? 'active' : '' }}">
                            <i class="fa fa-calendar-week me-2"></i>Bi-Annually
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('reports_quarterly') }}" class="dropdown-item {{ Request::is('reports_quarterly') ? 'active' : '' }}">
                            <i class="fa fa-calendar-alt me-2"></i>Quarterly
                        </a>
                    </li>
                </ul>
            </div>

            <a href="{{ url('past_reports') }}" class="nav-item nav-link {{ Request::is('past_reports') ? 'active' : '' }}">
                <i class="fa fa-archive me-2"></i>Past reports
            </a>

            <!-- Rankings -->
            <a href="{{ url('rankings') }}" class="nav-item nav-link {{ Request::is('rankings') ? 'active' : '' }}">
                <i class="fa fa-trophy me-2"></i>Rankings
            </a>

            <!-- Services -->
            <a href="{{ url('view_services') }}" class="nav-item nav-link {{ Request::is('view_services') ? 'active' : '' }}">
                <i class="fa fa-cogs me-2"></i>Services
            </a>

            <!-- Account -->
            <a href="{{ url('account') }}" class="nav-item nav-link {{ Request::is('account') ? 'active' : '' }}">
                <i class="fa fa-user-cog me-2"></i>Account
            </a>

            <a href="{{ url('field-counts') }}" class="nav-item nav-link {{ Request::is('field-counts') ? 'active' : '' }}">
    <i class="fa fa-lightbulb me-2"></i>Suggestions
</a>


        </div>
    </nav>
</div>
