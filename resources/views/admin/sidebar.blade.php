<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ url('admin/dashboard') }}" class="navbar-brand mx-4 mb-3 d-flex align-items-center">
            <img src="{{ asset('image/Urkl.png') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
            <h3 class="text-primary mb-0">PSU <span class="text-gold">ACC</span></h3>
        </a>

        <div class="navbar-nav w-100">
            <a href="{{ url('admin/dashboard') }}" class="nav-item nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ Request::is('external*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-external-link-alt me-2"></i>External Forms
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('external/admission') }}" class="dropdown-item">Admission, Guidance and Testing</a>
                    <a href="{{ url('external/cashier') }}" class="dropdown-item">Cashier</a>
                    <a href="{{ url('external/college') }}" class="dropdown-item">College/Department</a>
                    <a href="{{ url('external/library') }}" class="dropdown-item">Library and Audio Visuals</a>
                    <a href="{{ url('external/nstp') }}" class="dropdown-item">NSTP</a>
                    <a href="{{ url('external/registrar') }}" class="dropdown-item">Registrar</a>
                    <a href="{{ url('external/student_services') }}" class="dropdown-item">Student Services and Alumni affairs</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ Request::is('internal*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-file-alt"></i>Internal Forms
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('internal/admission') }}" class="dropdown-item">Admission, Guidance and Testing</a>
                    <a href="{{ url('internal/cashier') }}" class="dropdown-item">Cashier</a>
                    <a href="{{ url('internal/college') }}" class="dropdown-item">College/Department</a>
                    <a href="{{ url('internal/library') }}" class="dropdown-item">Library and Audio Visuals</a>
                    <a href="{{ url('internal/nstp') }}" class="dropdown-item">NSTP</a>
                    <a href="{{ url('internal/registrar') }}" class="dropdown-item">Registrar</a>
                    <a href="{{ url('internal/student_services') }}" class="dropdown-item">Student Services and Alumni affairs</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ Request::is('reports*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-chart-bar me-2"></i>Reports
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('reports') }}" class="dropdown-item">Annually</a>
                    <a href="{{ url('reports_bi_quarterly') }}" class="dropdown-item">Bi-Quarterly</a>
                    <a href="{{ url('reports_quarterly') }}" class="dropdown-item">Quarterly</a>
                </div>
            </div>

            <a href="{{ url('rankings') }}" class="nav-item nav-link {{ Request::is('rankings') ? 'active' : '' }}">
                <i class="fa fa-sort-numeric-up-alt me-2"></i>Rankings
            </a>
            <a href="{{ url('view_services') }}" class="nav-item nav-link {{ Request::is('view_services') ? 'active' : '' }}">
                <i class="fa fa-building"></i>Services
            </a>
            <a href="{{ url('account') }}" class="nav-item nav-link {{ Request::is('account') ? 'active' : '' }}">
                <i class="fa fa-user me-2"></i>Account
            </a>
        </div>
    </nav>
</div>
