<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <!-- <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-bars"></i></h2>
    </a> -->
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>

    <!-- Navbar Collapse -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto align-items-center">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-2" src="{{asset('image/images.jpg')}}" alt="Profile Picture" style="width: 40px; height: 40px;">
                    <span class="d-none d-lg-inline-flex">Admin admin</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                    <a href="#" class="dropdown-item">My Profile</a>
                    <a href="#" class="dropdown-item">Settings</a>
                    <!-- Logout Form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item" style="cursor: pointer;">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
