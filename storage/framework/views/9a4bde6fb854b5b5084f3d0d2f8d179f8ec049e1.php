<?php $__env->startSection('title','Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Welcome back! Here's an overview of your food platform.</p>
        </div>
    </div>

    <div class="stats-grid" id="stats-grid">
        <a href="/admin/categories" class="stat-card stat-card-link">
            <span class="stat-icon"><svg class="icon icon-xl"><use href="#icon-star"></use></svg></span>
            <div class="stat-value" id="stat-categories">—</div>
            <div class="stat-label">Categories</div>
        </a>
        <a href="/admin/restaurants" class="stat-card stat-card-link">
            <span class="stat-icon"><svg class="icon icon-xl"><use href="#icon-map-pin"></use></svg></span>
            <div class="stat-value" id="stat-restaurants">—</div>
            <div class="stat-label">Restaurants</div>
        </a>
        <a href="/admin/dishes" class="stat-card stat-card-link">
            <span class="stat-icon"><svg class="icon icon-xl"><use href="#icon-dish"></use></svg></span>
            <div class="stat-value" id="stat-dishes">—</div>
            <div class="stat-label">Total Dishes</div>
        </a>
        <a href="/admin/disapprovals" class="stat-card stat-card-link">
            <span class="stat-icon"><svg class="icon icon-xl"><use href="#icon-clock"></use></svg></span>
            <div class="stat-value" id="stat-pending">—</div>
            <div class="stat-label">Pending Approval</div>
        </a>
        <a href="/admin/admins" class="stat-card stat-card-link">
            <span class="stat-icon"><svg class="icon icon-xl"><use href="#icon-user"></use></svg></span>
            <div class="stat-value" id="stat-admins">—</div>
            <div class="stat-label">Admin Users</div>
        </a>
        <a href="/admin/users" class="stat-card stat-card-link">
            <span class="stat-icon"><svg class="icon icon-xl"><use href="#icon-users"></use></svg></span>
            <div class="stat-value" id="stat-users">—</div>
            <div class="stat-label">Website Users</div>
        </a>
    </div>

    <div class="dashboard-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Quick Actions</h2>
            </div>
            <div class="card-body" style="padding: 1rem;">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <a href="/admin/categories/create" style="display: flex; align-items: center; gap: 0.875rem; padding: 1rem; background: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px; text-decoration: none; transition: transform 0.15s, box-shadow 0.15s;">
                        <span style="width: 44px; height: 44px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 22px; height: 22px; stroke: white; fill: none;"><use href="#icon-star"></use></svg>
                        </span>
                        <span>
                            <span style="display: block; font-weight: 600; color: #92400e; font-size: 0.9375rem;">Add Category</span>
                            <span style="display: block; font-size: 0.75rem; color: #b45309;">Create new food category</span>
                        </span>
                    </a>
                    <a href="/admin/restaurants/create" style="display: flex; align-items: center; gap: 0.875rem; padding: 1rem; background: #ecfdf5; border: 1px solid #6ee7b7; border-radius: 10px; text-decoration: none; transition: transform 0.15s, box-shadow 0.15s;">
                        <span style="width: 44px; height: 44px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 22px; height: 22px; stroke: white; fill: none;"><use href="#icon-map-pin"></use></svg>
                        </span>
                        <span>
                            <span style="display: block; font-weight: 600; color: #065f46; font-size: 0.9375rem;">Add Restaurant</span>
                            <span style="display: block; font-size: 0.75rem; color: #047857;">List a new restaurant</span>
                        </span>
                    </a>
                    <a href="/admin/disapprovals" style="display: flex; align-items: center; gap: 0.875rem; padding: 1rem; background: #eff6ff; border: 1px solid #93c5fd; border-radius: 10px; text-decoration: none; transition: transform 0.15s, box-shadow 0.15s;">
                        <span style="width: 44px; height: 44px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 22px; height: 22px; stroke: white; fill: none;"><use href="#icon-clock"></use></svg>
                        </span>
                        <span>
                            <span style="display: block; font-weight: 600; color: #1e40af; font-size: 0.9375rem;">Review Pending</span>
                            <span style="display: block; font-size: 0.75rem; color: #1d4ed8;">Approve or reject items</span>
                        </span>
                    </a>
                    <a href="/admin/cms-pages/create" style="display: flex; align-items: center; gap: 0.875rem; padding: 1rem; background: #f5f3ff; border: 1px solid #c4b5fd; border-radius: 10px; text-decoration: none; transition: transform 0.15s, box-shadow 0.15s;">
                        <span style="width: 44px; height: 44px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 22px; height: 22px; stroke: white; fill: none;"><use href="#icon-edit"></use></svg>
                        </span>
                        <span>
                            <span style="display: block; font-weight: 600; color: #5b21b6; font-size: 0.9375rem;">Add CMS Page</span>
                            <span style="display: block; font-size: 0.75rem; color: #6d28d9;">Create content pages</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="card-title">Recent Restaurants</h2>
                <a href="/admin/restaurants" style="font-size: 0.8rem; color: var(--primary); text-decoration: none; font-weight: 500;">View All →</a>
            </div>
            <div class="card-body" id="recent-restaurants" style="padding: 0;">
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 3rem 1rem; color: #64748b;">
                    <div style="width: 32px; height: 32px; border: 3px solid #e2e8f0; border-top-color: var(--primary); border-radius: 50%; animation: spin 0.8s linear infinite;"></div>
                    <span style="margin-top: 1rem; font-size: 0.875rem;">Loading restaurants...</span>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .dashboard-grid .card {
        border-radius: 12px;
    }
    
    .stat-card-link {
        text-decoration: none;
        color: inherit;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    
    .stat-card-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: var(--primary);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
async function loadDashboardStats() {
    try {
        const [categoriesResult, restaurants, allDishes, pendingDishes, admins, users] = await Promise.all([
            adminFetch('GET', '/admin/api/categories'),
            adminFetch('GET', '/admin/api/restaurants'),
            adminFetch('GET', '/admin/api/dishes').catch(() => []),
            adminFetch('GET', '/admin/api/dishes/pending').catch(() => []),
            adminFetch('GET', '/admin/api/admins').catch(() => []),
            adminFetch('GET', '/admin/api/users').catch(() => [])
        ]);
        
        const categories = categoriesResult?.data || categoriesResult || [];
        document.getElementById('stat-categories').textContent = categories?.length || 0;
        document.getElementById('stat-restaurants').textContent = restaurants?.length || 0;
        document.getElementById('stat-admins').textContent = admins?.length || 0;
        document.getElementById('stat-users').textContent = users?.length || 0;
        document.getElementById('stat-dishes').textContent = allDishes?.length || 0;
        document.getElementById('stat-pending').textContent = pendingDishes?.length || 0;
        
        // Recent restaurants
        const recentContainer = document.getElementById('recent-restaurants');
        if (restaurants && restaurants.length) {
            const recentItems = restaurants.slice(0, 5).map(r => `
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9;">
                    <div style="display: flex; align-items: center; gap: 0.875rem; flex: 1; min-width: 0;">
                        <span style="width: 40px; height: 40px; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width: 20px; height: 20px; stroke: #64748b; fill: none;"><use href="#icon-map-pin"></use></svg>
                        </span>
                        <div style="min-width: 0;">
                            <div style="font-weight: 600; color: #1e293b; font-size: 0.9375rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${r.name}</div>
                            <div style="font-size: 0.75rem; color: #64748b;">${r.city || r.address || 'No location'}</div>
                        </div>
                    </div>
                    <a href="/admin/restaurants/${r.id}/edit" class="btn btn-secondary btn-sm">Edit</a>
                </div>
            `).join('');
            recentContainer.innerHTML = recentItems;
        } else {
            recentContainer.innerHTML = `
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 3rem 1rem; color: #64748b; text-align: center;">
                    <span style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;">
                        <svg style="width: 24px; height: 24px; stroke: #94a3b8; fill: none;"><use href="#icon-map-pin"></use></svg>
                    </span>
                    <span style="font-size: 0.875rem; margin-bottom: 0.75rem;">No restaurants yet</span>
                    <a href="/admin/restaurants/create" class="btn btn-primary btn-sm">Add Your First Restaurant</a>
                </div>
            `;
        }
    } catch (e) {
        console.error('Failed to load stats:', e);
        document.getElementById('recent-restaurants').innerHTML = `
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 3rem 1rem; color: #64748b; text-align: center;">
                <span style="font-size: 0.875rem; margin-bottom: 0.75rem;">Failed to load data</span>
                <button onclick="loadDashboardStats()" class="btn btn-secondary btn-sm">Try Again</button>
            </div>
        `;
    }
}

loadDashboardStats();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>