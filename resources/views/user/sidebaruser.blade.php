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

            

           
        </div>
    </nav>
</div>
