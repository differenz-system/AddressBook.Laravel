<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Address Book') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
    <style>
        .sidebar {
            width: 250px;
            min-width: 250px;
            max-width: 250px;
            transition: all 0.3s ease-in-out;
            overflow-x: hidden;
            white-space: nowrap;
        }

        .sb-link {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.2s;
        }

        .sb-link i {
            font-size: 1.2rem;
            margin-right: 10px;
            transition: margin 0.3s ease;
        }

        .sb-link:hover,
        .sb-link.active {
            background-color: rgba(255, 255, 255, 0.1);
        }


        /* =========================================
        Sidebar Collapsed State
        ========================================= */
        .sidebar-collapsed .sidebar {
            width: 80px;
            min-width: 80px;
            max-width: 80px;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        /* Hide text and labels */
        .sidebar-collapsed .sidebar .label,
        .sidebar-collapsed .sidebar .sb-user-meta,
        .sidebar-collapsed .sidebar .brand {
            display: none;
        }

        /* Center icons in the collapsed state */
        .sidebar-collapsed .sidebar .d-flex.align-items-center {
            justify-content: center !important;
        }

        /* Fix link padding and center the icon */
        .sidebar-collapsed .sidebar .sb-link {
            justify-content: center;
            padding: 10px 0;
        }

        /* Remove margins from icons so they center perfectly */
        .sidebar-collapsed .sidebar .sb-link i,
        .sidebar-collapsed .sidebar button i {
            margin-right: 0 !important;
        }

        /* Center the logout button */
        .sidebar-collapsed .sidebar #logout-form button {
            padding-left: 0;
            padding-right: 0;
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body class="layout-root">
    <div class="d-flex" style="min-height: 100vh;">
        <nav class="sidebar bg-dark text-white p-3 d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="brand mb-0">Address Book</h5>
            </div>

            <ul class="nav flex-column gap-1 mb-3">
                <li class="nav-item">
                    <a class="sb-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                        <i class="bi bi-speedometer2"></i> <span class="label">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sb-link {{ request()->routeIs('contacts.*') ? 'active' : '' }}" href="{{ route('contacts.index') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Contacts">
                        <i class="bi bi-person-lines-fill"></i> <span class="label">Contacts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sb-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}" href="{{ route('favorites.index') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Favorites">
                        <i class="bi bi-star"></i> <span class="label">Favorites</span>
                    </a>
                </li>
            </ul>

            <div class="mt-auto">
                <div class="sb-user mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                        <div class="sb-user-meta">
                            <div class="sb-user-name">{{ auth()->user()->name ?? '' }}</div>
                        </div>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> <span class="label">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
        <main class="flex-grow-1 main-content">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
                <div class="container-fluid">
                    <button id="sidebarToggle" class="btn btn-outline-secondary me-2" type="button">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted small">{{ auth()->user()->name ?? '' }}</span>
                    </div>
                </div>
            </nav>
            <div class="container-fluid p-4 content-scroll">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    @stack('scripts')

    <script>
        // Restore sidebar state
        (function() {
            const collapsed = localStorage.getItem('sb-collapsed') === '1';
            if (collapsed) document.body.classList.add('sidebar-collapsed');
            setupSidebarTooltips();
        })();
        // Toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
            const isCollapsed = document.body.classList.contains('sidebar-collapsed');
            localStorage.setItem('sb-collapsed', isCollapsed ? '1' : '0');
            setupSidebarTooltips();
        });

        function setupSidebarTooltips() {
            const collapsed = document.body.classList.contains('sidebar-collapsed');
            document.querySelectorAll('.sidebar [data-bs-toggle="tooltip"]').forEach(function(el) {
                const inst = bootstrap.Tooltip.getInstance(el);
                if (collapsed) {
                    if (!inst) new bootstrap.Tooltip(el, {
                        placement: 'right',
                        trigger: 'hover'
                    });
                } else {
                    if (inst) inst.dispose();
                }
            });
        }
    </script>
</body>

</html>
