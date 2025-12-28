@extends('admin.layout')

@section('title','Dashboard')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Welcome back! Here's an overview of your food platform.</p>
        </div>
    </div>

    <div class="stats-grid" id="stats-grid">
        <a href="/admin/categories" class="stat-card stat-card-link">
            <span class="stat-icon">📁</span>
            <div class="stat-value" id="stat-categories">—</div>
            <div class="stat-label">Categories</div>
        </a>
        <a href="/admin/restaurants" class="stat-card stat-card-link">
            <span class="stat-icon">🏪</span>
            <div class="stat-value" id="stat-restaurants">—</div>
            <div class="stat-label">Restaurants</div>
        </a>
        <a href="/admin/dishes" class="stat-card stat-card-link">
            <span class="stat-icon">🍽️</span>
            <div class="stat-value" id="stat-dishes">—</div>
            <div class="stat-label">Total Dishes</div>
        </a>
        <a href="/admin/disapprovals" class="stat-card stat-card-link">
            <span class="stat-icon">⏳</span>
            <div class="stat-value" id="stat-pending">—</div>
            <div class="stat-label">Pending Approval</div>
        </a>
        <a href="/admin/admins" class="stat-card stat-card-link">
            <span class="stat-icon">👑</span>
            <div class="stat-value" id="stat-admins">—</div>
            <div class="stat-label">Admin Users</div>
        </a>
        <a href="/admin/users" class="stat-card stat-card-link">
            <span class="stat-icon">👥</span>
            <div class="stat-value" id="stat-users">—</div>
            <div class="stat-label">Website Users</div>
        </a>
    </div>

    <div class="dashboard-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Quick Actions</h2>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="/admin/categories/create" class="quick-action-btn">
                        <span class="quick-action-icon">📁</span>
                        <span>Add Category</span>
                    </a>
                    <a href="/admin/restaurants/create" class="quick-action-btn">
                        <span class="quick-action-icon">🏪</span>
                        <span>Add Restaurant</span>
                    </a>
                    <a href="/admin/disapprovals" class="quick-action-btn">
                        <span class="quick-action-icon">📋</span>
                        <span>Review Pending</span>
                    </a>
                    <a href="/admin/cms-pages/create" class="quick-action-btn">
                        <span class="quick-action-icon">📄</span>
                        <span>Add CMS Page</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Recent Restaurants</h2>
            </div>
            <div class="card-body" id="recent-restaurants">
                <div class="loading-placeholder">Loading...</div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    
    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        text-decoration: none;
        color: #1e293b;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.15s;
    }
    
    .quick-action-btn:hover {
        background: #fff;
        border-color: var(--primary);
        box-shadow: 0 2px 8px rgba(235, 82, 2, 0.1);
    }
    
    .quick-action-icon {
        font-size: 1.5rem;
    }
    
    .recent-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.875rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .recent-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .recent-item:first-child {
        padding-top: 0;
    }
    
    .recent-item-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .recent-item-icon {
        width: 40px;
        height: 40px;
        background: #f1f5f9;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .recent-item-name {
        font-weight: 500;
        color: #1e293b;
    }
    
    .recent-item-meta {
        font-size: 0.75rem;
        color: #94a3b8;
    }
    
    .loading-placeholder {
        color: #94a3b8;
        font-size: 0.875rem;
        padding: 1rem 0;
        text-align: center;
    }
    
    .empty-state {
        color: #94a3b8;
        font-size: 0.875rem;
        text-align: center;
        padding: 2rem 1rem;
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
@endpush

@push('scripts')
<script>
async function loadDashboardStats() {
    try {
        const [categories, restaurants, allDishes, pendingDishes, admins, users] = await Promise.all([
            adminFetch('GET', '/admin/api/categories'),
            adminFetch('GET', '/admin/api/restaurants'),
            adminFetch('GET', '/admin/api/dishes').catch(() => []),
            adminFetch('GET', '/admin/api/dishes/pending').catch(() => []),
            adminFetch('GET', '/admin/api/admins').catch(() => []),
            adminFetch('GET', '/admin/api/users').catch(() => [])
        ]);
        
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
                <div class="recent-item">
                    <div class="recent-item-info">
                        <div class="recent-item-icon">🏪</div>
                        <div>
                            <div class="recent-item-name">${r.name}</div>
                            <div class="recent-item-meta">${r.city || r.address || 'No location'}</div>
                        </div>
                    </div>
                    <a href="/admin/restaurants/${r.id}/edit" class="btn btn-secondary btn-sm">View</a>
                </div>
            `).join('');
            recentContainer.innerHTML = recentItems;
        } else {
            recentContainer.innerHTML = '<div class="empty-state">No restaurants yet</div>';
        }
    } catch (e) {
        console.error('Failed to load stats:', e);
        document.getElementById('recent-restaurants').innerHTML = 
            '<div class="empty-state">Failed to load data</div>';
    }
}

loadDashboardStats();
</script>
@endpush
