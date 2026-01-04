<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — FOODCITA</title>
    <link rel="stylesheet" href="/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #eb5202;
            --primary-dark: #c94400;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --sidebar-active: #0f172a;
            --header-bg: #0f172a;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
            --border-color: #e2e8f0;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }
        * { box-sizing: border-box; }
        body { 
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif; 
            margin: 0; 
            background: #f1f5f9;
            color: #1e293b;
        }
        
        /* Header */
        .admin-header {
            background: linear-gradient(135deg, var(--header-bg) 0%, #1e3a5f 100%);
            color: #fff;
            padding: 0 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .admin-header h1 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .header-user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255,255,255,0.1);
            border-radius: 6px;
            font-size: 0.875rem;
        }
        
        /* Layout */
        .admin-wrapper {
            display: flex;
            padding-top: 60px;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 250px;
            background: var(--sidebar-bg);
            min-height: calc(100vh - 60px);
            position: fixed;
            top: 60px;
            left: 0;
            overflow-y: auto;
            padding: 1rem 0;
        }
        .sidebar-section {
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
        }
        .sidebar-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            margin-bottom: 0.5rem;
            padding: 0 0.75rem;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.875rem;
            border-radius: 6px;
            margin: 0 0.5rem 0.25rem;
            transition: all 0.15s;
        }
        .nav-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }
        .nav-link.active {
            background: var(--primary);
            color: #fff;
            font-weight: 500;
        }
        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        
        /* Main content */
        .admin-main {
            flex: 1;
            margin-left: 250px;
            padding: 1.5rem;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 1rem;
        }
        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        /* Cards */
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
        }
        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
            color: #1e293b;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            background: #f8fafc;
            border-radius: 0 0 8px 8px;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 6px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }
        .btn-primary {
            background: var(--primary);
            color: #fff;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        .btn-secondary {
            background: #fff;
            color: #475569;
            border-color: var(--border-color);
        }
        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        .btn-success {
            background: var(--success);
            color: #fff;
        }
        .btn-danger {
            background: var(--danger);
            color: #fff;
        }
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }
        .btn-icon {
            padding: 0.5rem;
            width: 36px;
            height: 36px;
            justify-content: center;
        }
        
        /* Forms */
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.375rem;
        }
        .form-control {
            width: 100%;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(235, 82, 2, 0.1);
        }
        .form-control::placeholder {
            color: #94a3b8;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        .form-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        
        /* Search bar */
        .search-bar {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        .search-input-wrapper {
            flex: 1;
            min-width: 250px;
            position: relative;
        }
        .search-input-wrapper .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.5;
            width: 1rem;
            height: 1rem;
        }
        .search-input {
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.25rem;
            font-size: 0.875rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: #fff;
        }
        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(235, 82, 2, 0.1);
        }
        
        /* Table / Grid */
        .data-grid {
            overflow-x: auto;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        .data-table th {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
            position: relative;
        }
        .data-table th.sortable {
            cursor: pointer;
            user-select: none;
        }
        .data-table th.sortable:hover {
            background: #f1f5f9;
        }
        .data-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            color: #334155;
        }
        .data-table tbody tr:hover {
            background: #fefce8;
        }
        .data-table .actions {
            display: flex;
            gap: 0.5rem;
            white-space: nowrap;
        }
        
        /* Column toggle */
        .column-toggle {
            position: relative;
        }
        .column-toggle-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            min-width: 200px;
            z-index: 50;
            padding: 0.5rem;
            max-height: 300px;
            overflow-y: auto;
        }
        .column-toggle-menu.show {
            display: block;
        }
        .column-toggle-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
        }
        .column-toggle-item:hover {
            background: #f1f5f9;
        }
        .column-toggle-item input {
            accent-color: var(--primary);
        }
        
        /* Toggle Switch */
        .toggle-switch {
            display: flex;
            align-items: center;
            cursor: pointer;
            gap: 0.75rem;
        }
        .toggle-switch input {
            display: none;
        }
        .toggle-slider {
            width: 48px;
            height: 26px;
            background: #cbd5e1;
            border-radius: 26px;
            position: relative;
            transition: background 0.3s;
        }
        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            top: 3px;
            left: 3px;
            transition: transform 0.3s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .toggle-switch input:checked + .toggle-slider {
            background: var(--primary);
        }
        .toggle-switch input:checked + .toggle-slider::before {
            transform: translateX(22px);
        }
        .toggle-label {
            font-weight: 500;
            color: #334155;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.875rem;
            color: #64748b;
        }
        .pagination-info {}
        .pagination-controls {
            display: flex;
            gap: 0.25rem;
        }
        .pagination-btn {
            padding: 0.375rem 0.75rem;
            border: 1px solid var(--border-color);
            background: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
        }
        .pagination-btn:hover:not(:disabled) {
            background: #f1f5f9;
        }
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .pagination-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }
        
        /* Status badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: 9999px;
        }
        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }
        
        /* Page header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #0f172a;
            margin: 0;
        }
        .page-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            margin: 0.25rem 0 0;
        }
        
        /* Stats cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: #fff;
            border-radius: 8px;
            padding: 1.25rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #0f172a;
        }
        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.25rem;
        }
        .stat-icon {
            float: right;
            font-size: 2rem;
            opacity: 0.3;
        }
        
        /* Modal improvements */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            z-index: 200;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal-overlay.show {
            display: flex;
        }
        .modal-content {
            background: #fff;
            border-radius: 12px;
            width: 100%;
            max-width: 640px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        .modal-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
        }
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
            padding: 0;
            line-height: 1;
        }
        .modal-close:hover {
            color: #0f172a;
        }
        .modal-body {
            padding: 1.5rem;
        }
        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            background: #f8fafc;
            border-radius: 0 0 12px 12px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            }
        }
        
        /* Utility classes */
        .text-muted { color: #64748b; }
        .text-sm { font-size: 0.875rem; }
        .text-xs { font-size: 0.75rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-4 { margin-top: 1rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .hidden { display: none !important; }
    </style>
</head>
<body>
    @include('partials.icons')
    
    <header class="admin-header">
        <h1><svg class="icon icon-lg" style="color: var(--primary);"><use href="#icon-utensils"></use></svg> FOODCITA Admin</h1>
        <div class="header-actions">
            <div class="header-user">
                <svg class="icon"><use href="#icon-user"></use></svg>
                <span>Admin</span>
            </div>
            <form method="POST" action="{{ url('/admin/logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="btn btn-secondary btn-sm">Logout</button>
            </form>
        </div>
    </header>

    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            @include('admin._nav')
        </aside>

        <main class="admin-main">
            @yield('content')
        </main>
    </div>

    <!-- Modal placeholder -->
    <div class="modal-overlay" id="admin-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Modal</h3>
                <button class="modal-close" id="admin-modal-close">&times;</button>
            </div>
            <div class="modal-body" id="admin-modal-body"></div>
            <div class="modal-footer" id="admin-modal-footer"></div>
        </div>
    </div>

    <script>
    // Modal helpers
    window.adminModal = {
        open(title, body, footer = '') {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('admin-modal-body').innerHTML = body;
            document.getElementById('admin-modal-footer').innerHTML = footer;
            document.getElementById('admin-modal').classList.add('show');
        },
        close() {
            document.getElementById('admin-modal').classList.remove('show');
        }
    };
    document.getElementById('admin-modal-close').addEventListener('click', () => window.adminModal.close());
    document.getElementById('admin-modal').addEventListener('click', (e) => {
        if (e.target.id === 'admin-modal') window.adminModal.close();
    });

    // Fetch helper
    async function adminFetch(method, url, body) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const opts = { 
            method, 
            credentials: 'same-origin', 
            headers: { 
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            } 
        };
        if (body) {
            opts.headers['Content-Type'] = 'application/json';
            opts.body = JSON.stringify(body);
        }
        const res = await fetch(url, opts);
        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            // Handle session expiration - redirect to login
            if (res.status === 401) {
                window.location.href = '/admin/login';
                throw new Error('Session expired. Please login again.');
            }
            throw new Error(err.message || err.error || 'Request failed');
        }
        return res.json().catch(() => null);
    }

    // Column visibility management
    window.columnManager = {
        storageKey: 'admin_columns_',
        get(gridId) {
            try {
                return JSON.parse(localStorage.getItem(this.storageKey + gridId)) || {};
            } catch { return {}; }
        },
        save(gridId, columns) {
            localStorage.setItem(this.storageKey + gridId, JSON.stringify(columns));
        },
        toggle(gridId, column, visible) {
            const cols = this.get(gridId);
            cols[column] = visible;
            this.save(gridId, cols);
        }
    };

    // Admin settings
    window.adminSettings = {};
    (async function() {
        try {
            const s = await adminFetch('GET', '/admin/api/settings');
            window.adminSettings = s || {};
        } catch (e) { /* ignore */ }
    })();
    </script>

    @stack('scripts')
</body>
</html>
