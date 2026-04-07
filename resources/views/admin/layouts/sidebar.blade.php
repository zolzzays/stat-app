<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    Хянах самбар
                </a>
            </li>

            <!-- Тохиргоо (submenu) -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center"
                   data-bs-toggle="collapse"
                   href="#settingsMenu"
                   role="button"
                   aria-expanded="false"
                   aria-controls="settingsMenu">
                    Тохиргоо
                    <span class="ms-2">▾</span>
                </a>

                <div class="collapse ps-3" id="settingsMenu">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="#">
                              Хэрэглэгч
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="#">
                               Байгууллага
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <!-- Orders -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Orders
                </a>
            </li>

            <!-- Reports -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Reports
                </a>
            </li>

        </ul>
    </div>
</nav>
