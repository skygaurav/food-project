<nav>
    <div class="sidebar-section">
        <div class="sidebar-section-title">Main</div>
        <a href="/admin" class="nav-link {{ request()->is('admin') && !request()->is('admin/*') ? 'active' : '' }}">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>
    </div>
    
    <div class="sidebar-section">
        <div class="sidebar-section-title">Catalog</div>
        <a href="/admin/categories" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
            <span class="nav-icon">📁</span>
            Categories
        </a>
        <a href="/admin/restaurants" class="nav-link {{ request()->is('admin/restaurants*') ? 'active' : '' }}">
            <span class="nav-icon">🏪</span>
            Restaurants
        </a>
        <a href="/admin/dishes" class="nav-link {{ request()->is('admin/dishes*') ? 'active' : '' }}">
            <span class="nav-icon">🍽️</span>
            Dishes
        </a>
    </div>
    
    <div class="sidebar-section">
        <div class="sidebar-section-title">Moderation</div>
        <a href="/admin/disapprovals" class="nav-link {{ request()->is('admin/disapprovals*') ? 'active' : '' }}">
            <span class="nav-icon">⚠️</span>
            Pending Approval
        </a>
    </div>
    
    <div class="sidebar-section">
        <div class="sidebar-section-title">System</div>
        <a href="/admin/settings" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
            <span class="nav-icon">⚙️</span>
            Settings
        </a>
    </div>
</nav>
