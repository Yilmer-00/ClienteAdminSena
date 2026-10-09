<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #39A900;">
    <div class="container">
        <!-- Logo / Título Principal -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
            <span class="me-2 fs-5">Cliente</span> AdminSENA
        </a>

        <!-- Botón hamburguesa para dispositivos móviles -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Enlaces de Navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-1">

                <!-- Módulo de Áreas -->
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded transition {{ request()->routeIs('area.*') ? 'bg-white text-success shadow-sm' : 'text-white' }}" href="{{ route('area.index') }}">
                        Areas
                    </a>
                </li>

                <!-- Módulo de Centros de Formación -->
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded transition {{ request()->routeIs('trainig-center.*') ? 'bg-white text-success shadow-sm' : 'text-white' }}" href="{{ route('trainig-center.index') }}">
                        Centros
                    </a>
                </li>

                <!-- Módulo de Computadores -->
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded transition {{ request()->routeIs('computer.*') ? 'bg-white text-success shadow-sm' : 'text-white' }}" href="{{ route('computer.index') }}">
                        Inventario PC
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>