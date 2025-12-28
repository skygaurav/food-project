<nav>
    <div class="sidebar-section">
        <div class="sidebar-section-title">Main</div>
        <a href="/admin" class="nav-link <?php echo e(request()->is('admin') && !request()->is('admin/*') ? 'active' : ''); ?>">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>
    </div>
    
    <div class="sidebar-section">
        <div class="sidebar-section-title">Catalog</div>
        <a href="/admin/categories" class="nav-link <?php echo e(request()->is('admin/categories*') ? 'active' : ''); ?>">
            <span class="nav-icon">📁</span>
            Categories
        </a>
        <a href="/admin/restaurants" class="nav-link <?php echo e(request()->is('admin/restaurants*') ? 'active' : ''); ?>">
            <span class="nav-icon">🏪</span>
            Restaurants
        </a>
        <a href="/admin/dishes" class="nav-link <?php echo e(request()->is('admin/dishes*') ? 'active' : ''); ?>">
            <span class="nav-icon">🍽️</span>
            Dishes
        </a>
    </div>
    
    <div class="sidebar-section">
        <div class="sidebar-section-title">Moderation</div>
        <a href="/admin/disapprovals" class="nav-link <?php echo e(request()->is('admin/disapprovals*') ? 'active' : ''); ?>">
            <span class="nav-icon">⚠️</span>
            Pending Approval
        </a>
    </div>
    
    <div class="sidebar-section">
        <div class="sidebar-section-title">System</div>
        <a href="/admin/settings" class="nav-link <?php echo e(request()->is('admin/settings*') ? 'active' : ''); ?>">
            <span class="nav-icon">⚙️</span>
            Settings
        </a>
    </div>
</nav>
<?php /**PATH /var/www/html/resources/views/admin/_nav.blade.php ENDPATH**/ ?>