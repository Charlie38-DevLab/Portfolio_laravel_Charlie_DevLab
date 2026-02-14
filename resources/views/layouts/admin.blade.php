<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Charlie DevLab</title>

    <style>
        :root {
            --primary: #6C5CE7;
            --primary-light: #A29BFE;
            --secondary: #00B8A9;
            --success: #00D4AA;
            --warning: #FFB800;
            --error: #FF4757;
            --dark-bg: #0A0E27;
            --dark-card: #151934;
            --dark-border: #1E2542;
            --text-primary: #FFFFFF;
            --text-secondary: #A0A0C0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Layout Principal */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Mobile Header */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 998;
            background: var(--dark-card);
            border-bottom: 1px solid var(--dark-border);
            padding: 1rem 1.5rem;
            align-items: center;
            justify-content: space-between;
        }

        .mobile-logo h1 {
            font-size: 1.3rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mobile-toggle {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            cursor: pointer;
            padding: 0.5rem;
            background: transparent;
            border: none;
        }

        .mobile-toggle span {
            width: 24px;
            height: 3px;
            background: var(--text-primary);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .mobile-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(7px, 7px);
        }

        .mobile-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: var(--dark-card);
            border-right: 1px solid var(--dark-border);
            padding: 2rem;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1001;
        }

        .admin-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--dark-border);
        }

        .admin-logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .admin-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.2rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-item:hover {
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.2), rgba(162, 155, 254, 0.1));
            color: var(--primary);
            border-left: 3px solid var(--primary);
        }

        .nav-icon {
            font-size: 1.3rem;
        }

        .nav-section {
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-secondary);
            padding: 0 1.2rem;
            margin-bottom: 0.5rem;
        }

        /* Contenu Principal */
        .admin-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        .admin-header {
            margin-bottom: 3rem;
        }

        .admin-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .admin-header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--dark-card);
            border-radius: 10px;
            overflow: hidden;
        }

        .data-table thead {
            background: rgba(108, 92, 231, 0.1);
        }

        .data-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 1px solid var(--dark-border);
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--dark-border);
            color: var(--text-secondary);
        }

        .data-table tbody tr:hover {
            background: rgba(108, 92, 231, 0.05);
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-completed, .badge-success, .badge-replied {
            background: rgba(0, 212, 170, 0.1);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .badge-pending, .badge-warning {
            background: rgba(255, 184, 0, 0.1);
            color: var(--warning);
            border: 1px solid var(--warning);
        }

        .badge-cancelled, .badge-error {
            background: rgba(255, 71, 87, 0.1);
            color: var(--error);
            border: 1px solid var(--error);
        }

        .badge-new, .badge-read {
            background: rgba(45, 140, 255, 0.1);
            color: #2D8CFF;
            border: 1px solid #2D8CFF;
        }

        /* Boutons */
        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(108, 92, 231, 0.4);
        }

        .btn-secondary {
            background: var(--dark-bg);
            color: var(--text-primary);
            border: 1px solid var(--dark-border);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
        }

        .btn-danger {
            background: var(--error);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 71, 87, 0.4);
        }

        /* Formulaires */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.8rem;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 1rem;
            background: var(--dark-bg);
            border: 1px solid var(--dark-border);
            border-radius: 10px;
            color: var(--text-primary);
            font-size: 1rem;
            font-family: inherit;
        }

        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(108, 92, 231, 0.05);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(0, 212, 170, 0.1);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .alert-error {
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid var(--error);
            color: var(--error);
        }

        .alert-warning {
            background: rgba(255, 184, 0, 0.1);
            border: 1px solid var(--warning);
            color: var(--warning);
        }

        /* Cards */
        .card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 15px;
            padding: 2rem;
        }

        /* Actions de table */
        .table-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem;
            border-radius: 6px;
            background: var(--dark-bg);
            border: 1px solid var(--dark-border);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .action-btn.delete:hover {
            border-color: var(--error);
            color: var(--error);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .page-link {
            padding: 0.8rem 1.2rem;
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .page-link.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* User menu */
        .user-menu {
            margin-top: auto;
            padding-top: 2rem;
            border-top: 1px solid var(--dark-border);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(108, 92, 231, 0.1);
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
        }

        .user-details h4 {
            font-size: 0.95rem;
            margin-bottom: 0.2rem;
        }

        .user-details p {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Overlay mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .mobile-header {
                display: flex;
            }

            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-content {
                margin-left: 0;
                padding-top: 80px;
            }

            .admin-logo {
                margin-bottom: 2rem;
                padding-bottom: 1.5rem;
            }

            .sidebar-overlay {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .admin-content {
                padding: 1rem;
                padding-top: 80px;
            }

            .admin-header h1 {
                font-size: 1.8rem;
            }

            .data-table {
                font-size: 0.9rem;
            }

            .data-table th,
            .data-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Mobile Header -->
        <header class="mobile-header">
            <div class="mobile-logo">
                <h1>🚀 Admin</h1>
            </div>
            <button class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </header>

        <!-- Overlay pour fermer le menu -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-logo">
                <h1>🚀 Admin</h1>
            </div>

            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    <span>Dashboard</span>
                </a>

                <div class="nav-section">
                    <div class="nav-section-title">Portfolio</div>
                </div>

                <a href="{{ route('admin.realisations.index') }}" class="nav-item {{ request()->routeIs('admin.realisations.*') ? 'active' : '' }}">
                    <span class="nav-icon">💼</span>
                    <span>Projets</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="nav-icon">🧑‍💻</span>
                    <span class="sidebar-text">Utilisateurs</span>
                </a>

                <a href="{{ route('admin.journeys.index') }}" class="nav-item {{ request()->routeIs('admin.journeys.*') ? 'active' : '' }}">
                    <span class="nav-icon">🧭</span>
                    <span>Parcours</span>
                </a>

                <a href="{{ route('admin.skills.index') }}" class="nav-item {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚡</span>
                    <span>Compétences</span>
                </a>

                <a href="{{ route('admin.experiences.index') }}" class="nav-item {{ request()->routeIs('admin.experiences.*') ? 'active' : '' }}">
                    <span class="nav-icon">🎯</span>
                    <span>Expériences</span>
                </a>

                <a href="{{ route('admin.educations.index') }}" class="nav-item {{ request()->routeIs('admin.educations.*') ? 'active' : '' }}">
                    <span class="nav-icon">🎓</span>
                    <span>Formations</span>
                </a>

                <div class="nav-section">
                    <div class="nav-section-title">E-commerce</div>
                </div>

                <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <span class="nav-icon">🛍️</span>
                    <span>Produits</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <span class="nav-icon">📦</span>
                    <span>Commandes</span>
                </a>

                <div class="nav-section">
                    <div class="nav-section-title">Événements & Blog</div>
                </div>

                <a href="{{ route('admin.events.index') }}" class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <span class="nav-icon">📅</span>
                    <span>Événements</span>
                </a>

                <a href="{{ route('admin.blog.index') }}" class="nav-item {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                    <span class="nav-icon">✍️</span>
                    <span>Blog</span>
                </a>

                <div class="nav-section">
                    <div class="nav-section-title">Communication</div>
                </div>

                <a href="{{ route('admin.contacts.index') }}" class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <span class="nav-icon">✉️</span>
                    <span>Messages</span>
                </a>
            </nav>

            <!-- User Menu -->
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>Administrateur</p>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="nav-item">
                    <span class="nav-icon">🏠</span>
                    <span>Voir le site</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-item" style="width: 100%; text-align: left; background: none; cursor: pointer;">
                        <span class="nav-icon">🚪</span>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenu Principal -->
        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.getElementById('mobileToggle');
            const adminSidebar = document.getElementById('adminSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const navLinks = document.querySelectorAll('.nav-item');

            // Toggle sidebar
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function(e) {
                    e.stopPropagation();

                    const isOpen = adminSidebar.classList.contains('open');

                    if (isOpen) {
                        // Fermer
                        adminSidebar.classList.remove('open');
                        sidebarOverlay.classList.remove('active');
                        this.classList.remove('active');
                        document.body.style.overflow = '';
                    } else {
                        // Ouvrir
                        adminSidebar.classList.add('open');
                        sidebarOverlay.classList.add('active');
                        this.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                });
            }

            // Fermer en cliquant sur l'overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    adminSidebar.classList.remove('open');
                    this.classList.remove('active');
                    if (mobileToggle) {
                        mobileToggle.classList.remove('active');
                    }
                    document.body.style.overflow = '';
                });
            }

            // Fermer en cliquant sur un lien
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 1024) {
                        adminSidebar.classList.remove('open');
                        sidebarOverlay.classList.remove('active');
                        if (mobileToggle) {
                            mobileToggle.classList.remove('active');
                        }
                        document.body.style.overflow = '';
                    }
                });
            });

            // Empêcher la propagation des clics dans la sidebar
            if (adminSidebar) {
                adminSidebar.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Auto-hide alerts
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.3s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
