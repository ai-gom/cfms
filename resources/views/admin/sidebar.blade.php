<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3 d-flex align-items-center">
            <img src="{{asset('image/Urkl.png')}}" alt="Logo" style="height: 40px; margin-right: 10px;">
            <h3 class="text-primary mb-0">PSU <span class="text-gold">ACC</span></h3>
        </a>

        <div class="navbar-nav w-100">
            <a href="{{url('admin/dashboard')}}" class="nav-item nav-link active">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>
            
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-external-link-alt me-2"></i>External Forms
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="form.html" class="dropdown-item">Admission, Guidance and Testing</a>
                    <a href="typography.html" class="dropdown-item">Cashier</a>
                    <a href="element.html" class="dropdown-item">College/Department</a>
                    <a href="element.html" class="dropdown-item">Library and Audio Visuals</a>
                    <a href="element.html" class="dropdown-item">NSTP</a>
                    <a href="element.html" class="dropdown-item">Registrar</a>
                    <a href="element.html" class="dropdown-item">Student Services and Alumni affairs</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-file-alt"></i>Internal Forms
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="button.html" class="dropdown-item">Admission, Guidance and Testing</a>
                    <a href="typography.html" class="dropdown-item">Cashier</a>
                    <a href="element.html" class="dropdown-item">College/Department</a>
                    <a href="element.html" class="dropdown-item">Library and Audio Visuals</a>
                    <a href="element.html" class="dropdown-item">NSTP</a>
                    <a href="element.html" class="dropdown-item">Registrar</a>
                    <a href="element.html" class="dropdown-item">Student Services and Alumni affairs</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-chart-bar me-2"></i>Reports
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{url('reports')}}" class="dropdown-item">Annually</a>
                    <a href="{{url('reports_bi_quarterly')}}" class="dropdown-item">Bi-Quarterly</a>
                    <a href="" class="dropdown-item">Quarterly</a>
                </div>
            </div>

            <a href="{{url('rankings')}}" class="nav-item nav-link">
                <i class="fa fa-sort-numeric-up-alt me-2"></i>Rankings
            </a>
            <a href="{{url('view_services')}}" class="nav-item nav-link">
                <i class="fa fa-building"></i>Services
            </a>
            <a href="{{url('account')}}" class="nav-item nav-link">
                <i class="fa fa-user me-2"></i>Account
            </a>
        </div>
    </nav>
</div>
