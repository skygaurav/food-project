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
        <div class="stat-card">
            <span class="stat-icon">📁</span>
            <div class="stat-value" id="stat-categories">—</div>
            <div class="stat-label">Categories</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">🏪</span>
            <div class="stat-value" id="stat-restaurants">—</div>
            <div class="stat-label">Restaurants</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">🍽️</span>
            <div class="stat-value" id="stat-dishes">—</div>
            <div class="stat-label">Total Dishes</div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">⏳</span>
            <div class="stat-value" id="stat-pending">—</div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Quick Actions</h2>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="/admin/categories/create" class="btn btn-primary">
                    <span>+</span> Add Category
                </a>
                <a href="/admin/restaurants/create" class="btn btn-primary">
                    <span>+</span> Add Restaurant
                </a>
                <a href="/admin/disapprovals" class="btn btn-secondary">
                    <span>📋</span> Review Pending Dishes
                </a>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h2 class="card-title">Recent Activity</h2>
        </div>
        <div class="card-body">
            <div id="recent-activity">Loading...</div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
async function loadDashboardStats() {
    try {
        const [categories, restaurants, dishes] = await Promise.all([
            adminFetch('GET', '/admin/api/categories'),
            adminFetch('GET', '/admin/api/restaurants'),
            adminFetch('GET', '/admin/api/dishes/pending').catch(() => [])
        ]);
        
        document.getElementById('stat-categories').textContent = categories?.length || 0;
        document.getElementById('stat-restaurants').textContent = restaurants?.length || 0;
        
        // Count total dishes from restaurants
        let totalDishes = 0;
        if (restaurants && restaurants.length) {
            restaurants.forEach(r => {
                if (r.dishes) totalDishes += r.dishes.length;
            });
        }
        document.getElementById('stat-dishes').textContent = totalDishes;
        document.getElementById('stat-pending').textContent = dishes?.length || 0;
        
        // Recent activity
        const activity = document.getElementById('recent-activity');
        const recentItems = [];
        
        if (restaurants && restaurants.length) {
            restaurants.slice(0, 3).forEach(r => {
                recentItems.push(`<div style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0;">
                    <strong>🏪 ${r.name}</strong> 
                    <span class="text-muted text-sm">— ${r.city || r.address || 'Restaurant'}</span>
                </div>`);
            });
        }
        
        activity.innerHTML = recentItems.length ? recentItems.join('') : '<p class="text-muted">No recent activity</p>';
    } catch (e) {
        console.error('Failed to load stats:', e);
    }
}

loadDashboardStats();
</script>
@endpush
