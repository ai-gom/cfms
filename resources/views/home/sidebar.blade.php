<div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a class="navbar-brand mx-4 mb-3 d-flex align-items-center">
                    <img src="{{ asset('image/Urkl.png') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
                    <h3 class="text-primary mb-0">PSU <span class="text-gold">ACC</span></h3>
                </a>
                <div class="navbar-nav w-100">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-laptop me-2"></i>Forms
                        </a>
                        <div class="dropdown-menu bg-transparent border-0">
                            @foreach($services as $service)
                                <a href="{{ url('/form?selected_service=' . $service->id) }}" class="dropdown-item">
                                    {{ $service->services_name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </nav>
        </div>