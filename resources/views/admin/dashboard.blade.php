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
        <div class="card quick-actions-card">
            <div class="card-header">
                <h2 class="card-title">
                    <svg class="icon" style="color: var(--primary);"><use href="#icon-star"></use></svg>
                    Quick Actions
                </h2>
                <span class="card-subtitle">Get things done faster</span>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="/admin/categories/create" class="quick-action-btn">
                        <span class="quick-action-icon qa-icon-amber">
                            <svg class="icon"><use href="#icon-star"></use></svg>
                        </span>
                        <span class="quick-action-content">
                            <span class="quick-action-title">Add Category</span>
                            <span class="quick-action-desc">Create new food category</span>
                        </span>
                        <svg class="icon quick-action-arrow"><use href="#icon-chevron-right"></use></svg>
                    </a>
                    <a href="/admin/restaurants/create" class="quick-action-btn">
                        <span class="quick-action-icon qa-icon-green">
                            <svg class="icon"><use href="#icon-map-pin"></use></svg>
                        </span>
                        <span class="quick-action-content">
                            <span class="quick-action-title">Add Restaurant</span>
                            <span class="quick-action-desc">List a new restaurant</span>
                        </span>
                        <svg class="icon quick-action-arrow"><use href="#icon-chevron-right"></use></svg>
                    </a>
                    <a href="/admin/disapprovals" class="quick-action-btn">
                        <span class="quick-action-icon qa-icon-blue">
                            <svg class="icon"><use href="#icon-clock"></use></svg>
                        </span>
                        <span class="quick-action-content">
                            <span class="quick-action-title">Review Pending</span>
                            <span class="quick-action-desc">Approve or reject items</span>
                        </span>
                        <svg class="icon quick-action-arrow"><use href="#icon-chevron-right"></use></svg>
                    </a>
                    <a href="/admin/cms-pages/create" class="quick-action-btn">
                        <span class="quick-action-icon qa-icon-purple">
                            <svg class="icon"><use href="#icon-edit"></use></svg>
                        </span>
                        <span class="quick-action-content">
                            <span class="quick-action-title">Add CMS Page</span>
                            <span class="quick-action-desc">Create content pages</span>
                        </span>
                        <svg class="icon quick-action-arrow"><use href="#icon-chevron-right"></use></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="card recent-restaurants-card">
            <div class="card-header">
                <h2 class="card-title">
                    <svg class="icon" style="color: var(--primary);"><use href="#icon-map-pin"></use></svg>
                    Recent Restaurants
                </h2>
                <a href="/admin/restaurants" class="card-header-link">View All →</a>
            </div>
            <div class="card-body" id="recent-restaurants">
                <div class="loading-placeholder">
                    <div class="loading-spinner"></div>
                    <span>Loading restaurants...</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    
    /* Card enhancements */
    .quick-actions-card,
    .recent-restaurants-card {
        border-radius: 16px !important;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }
    
    .quick-actions-card:hover,
    .recent-restaurants-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
    }
    
    .quick-actions-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
    }
    
    .recent-restaurants-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    
    .quick-actions-card .card-title,
    .recent-restaurants-card .card-title {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
    }
    
    .quick-actions-card .card-title .icon,
    .recent-restaurants-card .card-title .icon {
        width: 20px !important;
        height: 20px !important;
        flex-shrink: 0;
    }
    
    .card-subtitle {
        display: block;
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 400;
        margin-top: 0.25rem;
    }
    
    .card-header-link {
        font-size: 0.8rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.15s;
        white-space: nowrap;
    }
    
    .card-header-link:hover {
        color: var(--primary-dark);
    }
    
    /* Quick Actions Grid */
    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        padding: 0.5rem 0;
    }
    
    .quick-action-btn {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        text-decoration: none;
        color: #1e293b;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    
    .quick-action-btn::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--primary);
        transform: scaleY(0);
        transition: transform 0.2s ease;
    }
    
    .quick-action-btn:hover {
        background: #ffffff;
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(235, 82, 2, 0.15);
        transform: translateX(4px);
    }
    
    .quick-action-btn:hover::before {
        transform: scaleY(1);
    }
    
    .quick-action-icon {
        width: 48px;
        min-width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }
    
    .quick-action-btn:hover .quick-action-icon {
        transform: scale(1.1);
    }
    
    .quick-action-icon .icon {
        width: 24px !important;
        height: 24px !important;
        color: #fff !important;
        stroke: #fff !important;
    }
    
    /* Color variants for quick actions */
    .qa-icon-amber {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
    }
    
    .qa-icon-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }
    
    .qa-icon-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
    }
    
    .qa-icon-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        box-shadow: 0 4px 8px rgba(139, 92, 246, 0.3);
    }
    
    .quick-action-content {
        flex: 1;
        min-width: 0;
        display: inline-flex;
        flex-direction: column;
        gap: 0.125rem;
    }
    
    .quick-action-title {
        font-weight: 600;
        font-size: 0.9375rem;
        color: #1e293b;
        line-height: 1.3;
        display: block;
    }
    
    .quick-action-desc {
        font-size: 0.75rem;
        color: #64748b;
        line-height: 1.3;
        display: block;
    }
    
    .quick-action-arrow {
        width: 20px !important;
        min-width: 20px;
        height: 20px !important;
        color: #94a3b8;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    
    .quick-action-btn:hover .quick-action-arrow {
        color: var(--primary);
        transform: translateX(4px);
    }
    
    /* Recent Restaurants */
    .recent-restaurants-card .card-body {
        padding: 1rem 1.5rem;
    }
    
    .recent-item {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between;
        padding: 0.875rem 0;
        transition: background 0.2s ease;
    }
    
    .recent-item:not(:last-child) {
        border-bottom: 1px solid #f1f5f9;
    }
    
    .recent-item-info {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 0.875rem;
        flex: 1;
        min-width: 0;
    }
    
    .recent-item-icon {
        width: 44px;
        min-width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 10px;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    
    .recent-item:hover .recent-item-icon {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }
    
    .recent-item-icon .icon {
        width: 20px !important;
        height: 20px !important;
        color: #64748b;
        transition: color 0.2s ease;
    }
    
    .recent-item:hover .recent-item-icon .icon {
        color: #fff;
    }
    
    .recent-item-details {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
        min-width: 0;
        flex: 1;
    }
    
    .recent-item-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.9375rem;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .recent-item-meta {
        font-size: 0.75rem;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        line-height: 1.3;
    }
    
    .recent-item-meta .icon {
        width: 12px !important;
        height: 12px !important;
        flex-shrink: 0;
    }

    /* Loading state */
    .loading-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        padding: 3rem 1rem;
        color: #64748b;
        font-size: 0.875rem;
    }
    
    .loading-spinner {
        width: 32px;
        height: 32px;
        border: 3px solid #e2e8f0;
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 3rem 1rem;
        color: #64748b;
        font-size: 0.875rem;
        text-align: center;
    }
    
    .empty-state-icon {
        width: 56px;
        height: 56px;
        background: #f1f5f9;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .empty-state-icon .icon {
        width: 28px;
        height: 28px;
        color: #94a3b8;
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
    
    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
        
        .quick-action-btn {
            padding: 0.875rem 1rem;
        }
        
        .quick-action-icon-wrapper {
            width: 40px;
            min-width: 40px;
            height: 40px;
        }
    }
</style>
@endpush

@push('scripts')
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
                <div class="recent-item">
                    <div class="recent-item-info">
                        <div class="recent-item-icon">
                            <svg class="icon"><use href="#icon-map-pin"></use></svg>
                        </div>
                        <div class="recent-item-details">
                            <div class="recent-item-name">${r.name}</div>
                            <div class="recent-item-meta">
                                <svg class="icon"><use href="#icon-map-pin"></use></svg>
                                ${r.city || r.address || 'No location'}
                            </div>
                        </div>
                    </div>
                    <a href="/admin/restaurants/${r.id}/edit" class="btn btn-primary btn-sm">
                        <svg class="icon" style="width:14px;height:14px;margin-right:4px;"><use href="#icon-edit"></use></svg>
                        Edit
                    </a>
                </div>
            `).join('');
            recentContainer.innerHTML = recentItems;
        } else {
            recentContainer.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg class="icon"><use href="#icon-map-pin"></use></svg>
                    </div>
                    <span>No restaurants yet</span>
                    <a href="/admin/restaurants/create" class="btn btn-primary btn-sm">Add Your First Restaurant</a>
                </div>
            `;
        }
    } catch (e) {
        console.error('Failed to load stats:', e);
        document.getElementById('recent-restaurants').innerHTML = `
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg class="icon"><use href="#icon-clock"></use></svg>
                </div>
                <span>Failed to load data</span>
                <button onclick="loadDashboardStats()" class="btn btn-secondary btn-sm">Try Again</button>
            </div>
        `;
    }
}

loadDashboardStats();
</script>
@endpush
