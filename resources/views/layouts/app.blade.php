<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Статистик мэдээ')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { overflow-x: hidden; background: #f4f6f9; }

        /* ── Top header bar ── */
        .site-header {
            background: #fff;
            border-bottom: 3px solid #1a4fa0;
            padding: 0 24px;
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .site-header .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }
        .site-header .brand-logo {
            height: 56px;
            width: auto;
            object-fit: contain;
        }
        .site-header .brand-logo-placeholder {
            width: 56px;
            height: 56px;
            background: #1a4fa0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .site-header .brand-logo-placeholder span { font-size: 1.8rem; }
        .site-header .brand-text .org-name {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1a2f6e;
            letter-spacing: 0.02em;
            line-height: 1.2;
            text-transform: uppercase;
        }
        .site-header .brand-text .org-sub {
            font-size: 0.7rem;
            color: #5a6a8a;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .site-header .header-center {
            text-align: center;
            flex: 1;
            padding: 0 24px;
        }
        .site-header .header-center .sys-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: #1a2f6e;
            line-height: 1.4;
        }
        .site-header .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .site-header .user-info {
            text-align: right;
        }
        .site-header .user-info .user-label {
            font-size: 0.7rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .site-header .user-info .user-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: #1a2f6e;
        }
        .site-header .btn-logout {
            background: #1a4fa0;
            border: none;
            color: #fff;
            font-size: 0.82rem;
            padding: 6px 16px;
            border-radius: 4px;
            white-space: nowrap;
        }
        .site-header .btn-logout:hover {
            background: #153d80;
            color: #fff;
        }

        /* ── Sidebar ── */
        .sidebar { background: #1a2f6e; min-height: 100vh; }
        .sidebar-brand {
            background: #142558;
            padding: 14px 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        .sidebar-brand .sidebar-brand-text {
            color: #c8d8f8;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .sidebar a { color: #c8d8f8; display: block; padding: 10px 16px; text-decoration: none; font-size: 0.88rem; }
        .sidebar a:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .sidebar .submenu a { padding: 8px 16px 8px 32px; font-size: 0.83rem; color: #a8bce0; }
        .sidebar .submenu a:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .sidebar .section-title {
            color: #7a9bcc;
            font-size: 0.68rem;
            text-transform: uppercase;
            padding: 14px 16px 4px;
            letter-spacing: 0.1em;
        }
        .sidebar .collapse-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

<!-- ── Site Header ── -->
<header class="site-header">
    <div class="brand">
        @if(file_exists(public_path('images/logo.png')))
            <img src="{{ asset('images/logo.png') }}" alt="Лого" class="brand-logo">
        @else
            <div class="brand-logo-placeholder">
                <span>⚡</span>
            </div>
        @endif
     
    </div>

    <div class="header-center">
        <div class="sys-title">Эрчим хүчний салбарын үйлдвэрлэлт, борлуулалт,<br>хүний нөөцийн мэдээ мэдээлэл</div>
    </div>

    <div class="header-right">
        <div class="user-info">
            <div class="user-label">Хэрэглэгч</div>
            <div class="user-name">{{ auth()->user()->name ?? '' }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-logout">Гарах</button>
        </form>
    </div>
</header>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-0">
            <div class="sidebar-brand">
                <div class="sidebar-brand-text">Үндсэн цэс</div>
            </div>

            <a href="{{ route('dashboard') }}">🏠 Хянах самбар</a>
            <a href="{{ route('profile.edit') }}">👤 Миний мэдээлэл</a>

            <div class="section-title">Мэдээ</div>
            <a href="{{ route('plant_output.index') }}">⚡ Үйлдвэрлэлийн мэдээ</a>
            <a href="{{ route('energy_sales.index') }}">📦 Борлуулалтын мэдээ</a>
            <a href="{{ route('hr_count.index') }}">👥 Хүний нөөцийн мэдээ</a>

            @if(auth()->check() && auth()->user()->role?->name === 'admin')
            <div class="section-title">Тохиргоо</div>
            <a class="collapse-toggle" data-bs-toggle="collapse" href="#settingsMenu" role="button">
                ⚙️ Тохиргоо <span>▾</span>
            </a>
            <div class="collapse show submenu" id="settingsMenu">
                <a href="{{ route('powerplant.index') }}">➤ Станцын төрөл</a>
                <a href="{{ route('power_plants.index') }}">➤ Станц нэмэх</a>
                <a href="{{ route('organizations.index') }}">➤ Байгууллага</a>
                <a href="{{ route('users.index') }}">➤ Хэрэглэгч</a>
            </div>
            @endif
        </div>

        <!-- Main area -->
        <div class="col-md-10 p-0 d-flex flex-column" style="min-height: calc(100vh - 72px);">

            <!-- Flash messages -->
            <div class="px-4 pt-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="p-4 flex-grow-1">
                @yield('content')
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
