<nav>
    <div class="sidebar-section">
        <div class="sidebar-section-title">Main</div>
        <a href="/admin" class="nav-link {{ request()->is('admin') && !request()->is('admin/*') ? 'active' : '' }}">
            <svg class="icon nav-icon"><use href="#icon-home"></use></svg>
            Dashboard
        </a>
    </div>
    
    <div class="sidebar-section">
        <div class="sidebar-section-title">Catalog</div>
        <a href="/admin/categories" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
            <svg class="icon nav-icon"><use href="#icon-star"></use></svg>
            Categories
        </a>
        <a href="/admin/restaurants" class="nav-link {{ request()->is('admin/restaurants*') ? 'active' : '' }}">
            <svg class="icon nav-icon"><use href="#icon-map-pin"></use></svg>
            Restaurants
        </a>
        <a href="/admin/dishes" class="nav-link {{ request()->is('admin/dishes*') ? 'active' : '' }}">
            <svg class="icon nav-icon"><use href="#icon-dish"></use></svg>
            Dishes
        </a>
    </div>
    
    <div class="sidebar-section">
        <div class="sidebar-section-title">Moderation</div>
        <a href="/admin/disapprovals" class="nav-link {{ request()->is('admin/disapprovals*') ? 'active' : '' }}">
            <svg class="icon nav-icon"><use href="#icon-clock"></use></svg>
            Pending Approval
        </a>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-title">User Management</div>
        <a href="/admin/admins" class="nav-link {{ request()->is('admin/admins*') ? 'active' : '' }}">
            <svg class="icon nav-icon"><use href="#icon-user"></use></svg>
            Admin Users
        </a>
        <a href="/admin/users" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
            <svg class="icon nav-icon"><use href="#icon-users"></use></svg>
            Website Users
        </a>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-title">Content</div>
        <a href="/admin/cms-pages" class="nav-link {{ request()->is('admin/cms-pages*') ? 'active' : '' }}">
            <svg class="icon nav-icon"><use href="#icon-edit"></use></svg>
            CMS Pages
        </a>
    </div>
    
    <div class="sidebar-section">
        <div class="sidebar-section-title">System</div>
        <a href="/admin/settings" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
            <svg class="icon nav-icon"><use href="#icon-info"></use></svg>
            Settings
        </a>
    </div>
</nav>
