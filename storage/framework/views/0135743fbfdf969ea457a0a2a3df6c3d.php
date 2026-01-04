<?php $__env->startSection('meta_title', 'All Dishes - ' . ($seoSettings['site_name'] ?? 'FOODCITA')); ?>
<?php $__env->startSection('meta_description', 'Browse all delicious dishes from restaurants in your city. Find your next favorite meal.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .dishes-hero {
        text-align: center;
        padding: 3rem 0 2rem;
    }
    
    .dishes-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: var(--text-dark);
    }
    
    .dishes-subtitle {
        font-size: 1.1rem;
        color: var(--text-muted);
        margin: 0;
    }
    
    .stats-bar {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-value {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    
    .filter-section {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    
    .filter-grid {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    
    .filter-group {
        flex: 1;
        min-width: 150px;
    }
    
    .filter-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }
    
    .filter-group select,
    .filter-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        background: #fff;
        cursor: pointer;
    }
    
    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: var(--primary);
    }
    
    .dishes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    /* Use shared dish-card styles from frontend.blade.php */
    
    .loader {
        text-align: center;
        padding: 3rem;
    }
    
    .loader-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--primary);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #fff;
        border-radius: 16px;
    }
    
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }
    
    .empty-state-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.5rem;
        margin: 0 0 0.5rem 0;
        color: var(--text-dark);
    }
    
    .empty-state-text {
        color: var(--text-muted);
        margin: 0;
    }
    
    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .pagination-btn {
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        background: #fff;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    
    .pagination-btn:hover:not(:disabled) {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .pagination-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }
    
    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dishes-title {
            font-size: 2rem;
        }
        
        .filter-grid {
            flex-direction: column;
        }
        
        .filter-group {
            width: 100%;
        }
        
        .dishes-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
    <!-- Hero Section -->
    <div class="dishes-hero">
        <h1 class="dishes-title">🥘 All Dishes</h1>
        <p class="dishes-subtitle">Explore all delicious dishes from restaurants in your city</p>
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value" id="total-dishes">0</div>
                <div class="stat-label">Total Dishes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="total-categories">0</div>
                <div class="stat-label">Categories</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="total-restaurants">0</div>
                <div class="stat-label">Restaurants</div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="filter-section">
        <div class="filter-grid">
            <div class="filter-group">
                <label for="search">Search</label>
                <input type="text" id="search" placeholder="Search dishes...">
            </div>
            <div class="filter-group">
                <label for="category">Category</label>
                <select id="category">
                    <option value="">All Categories</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="city">City</label>
                <select id="city">
                    <option value="">All Cities</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="sort">Sort By</label>
                <select id="sort">
                    <option value="latest">Latest</option>
                    <option value="popular">Most Popular</option>
                    <option value="rating">Highest Rated</option>
                    <option value="name">Name (A-Z)</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Loader -->
    <div id="loader" class="loader">
        <div class="loader-spinner"></div>
    </div>
    
    <!-- Dishes Grid -->
    <div id="dishes-grid" class="dishes-grid" style="display: none;"></div>
    
    <!-- Empty State -->
    <div id="empty-state" class="empty-state" style="display: none;">
        <div class="empty-state-icon">🍽️</div>
        <h3 class="empty-state-title">No dishes found</h3>
        <p class="empty-state-text">Try adjusting your filters or check back later!</p>
    </div>
    
    <!-- Pagination -->
    <div id="pagination" class="pagination-container" style="display: none;"></div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let totalPages = 1;
    let totalDishes = 0;
    let allDishes = [];
    let cities = new Set();
    let searchTimeout = null;
    
    const grid = document.getElementById('dishes-grid');
    const loader = document.getElementById('loader');
    const emptyState = document.getElementById('empty-state');
    const pagination = document.getElementById('pagination');
    const categorySelect = document.getElementById('category');
    const citySelect = document.getElementById('city');
    const sortSelect = document.getElementById('sort');
    const searchInput = document.getElementById('search');
    
    // Load categories (API returns array directly or {data: []})
    async function loadCategories() {
        try {
            const response = await fetch('/api/categories');
            const result = await response.json();
            const categories = result.data || result;
            
            document.getElementById('total-categories').textContent = categories.length;
            
            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.slug;
                option.textContent = cat.name;
                categorySelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }
    
    // Update cities filter from dishes data
    function updateCitiesFilter() {
        const currentValue = citySelect.value;
        citySelect.innerHTML = '<option value="">All Cities</option>';
        
        Array.from(cities).sort().forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            if (city === currentValue) option.selected = true;
            citySelect.appendChild(option);
        });
    }
    
    // Load dishes
    async function loadDishes(page = 1) {
        loader.style.display = 'block';
        grid.style.display = 'none';
        emptyState.style.display = 'none';
        pagination.style.display = 'none';
        
        try {
            const params = new URLSearchParams();
            params.set('page', page);
            params.set('per_page', 12);
            
            if (categorySelect.value) params.set('category', categorySelect.value);
            if (citySelect.value) params.set('city', citySelect.value);
            if (sortSelect.value) params.set('sort', sortSelect.value);
            if (searchInput.value) params.set('search', searchInput.value);
            
            const response = await fetch('/api/dishes?' + params.toString());
            const data = await response.json();
            
            allDishes = data.data || [];
            currentPage = data.current_page || 1;
            totalPages = data.last_page || 1;
            totalDishes = data.total || allDishes.length;
            
            loader.style.display = 'none';
            
            // Extract cities from dishes for filter
            allDishes.forEach(dish => {
                if (dish.restaurant && dish.restaurant.city) {
                    cities.add(dish.restaurant.city);
                }
            });
            updateCitiesFilter();
            
            // Update stats
            document.getElementById('total-dishes').textContent = totalDishes;
            
            if (allDishes.length === 0) {
                emptyState.style.display = 'block';
                return;
            }
            
            renderDishes();
            renderPagination();
            
        } catch (error) {
            console.error('Error loading dishes:', error);
            loader.style.display = 'none';
            emptyState.style.display = 'block';
        }
    }
    
    // Render dishes - same format as home page
    function renderDishes() {
        grid.innerHTML = allDishes.map(dish => {
            // Find primary image or use first one
            let primaryImage = null;
            if (dish.images && dish.images.length > 0) {
                primaryImage = dish.images.find(img => img.is_primary) || dish.images[0];
            }
            let image = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';
            if (primaryImage) {
                const imgPath = primaryImage.path || primaryImage.image_path;
                if (imgPath) {
                    image = imgPath.startsWith('http') ? imgPath : '/storage/' + imgPath;
                }
            }
            
            const rating = dish.reviews_avg_rating ? parseFloat(dish.reviews_avg_rating).toFixed(1) : 'N/A';
            const likes = dish.likes_count || 0;
            const city = dish.restaurant ? dish.restaurant.city : '';
            const restaurant = dish.restaurant ? dish.restaurant.name : 'Unknown Restaurant';
            
            return `
                <article class="dish-card">
                    <a href="/dishes/${dish.slug}">
                        <img src="${image}" alt="${dish.name}" class="dish-card-image" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80'" />
                    </a>
                    <div class="dish-card-body">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.25rem;">
                            <a href="/dishes/${dish.slug}" style="text-decoration: none; color: inherit;">
                                <h3 class="dish-card-title">${dish.name}</h3>
                            </a>
                            ${city ? `<span style="font-size: 0.75rem; color: var(--text-muted); background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px;">${city}</span>` : ''}
                        </div>
                        <p class="dish-card-restaurant">${restaurant}</p>
                        <div class="dish-card-meta">
                            <!--<span class="dish-card-rating"><svg class="icon icon-sm icon-warning icon-filled"><use href="#icon-star-filled"></use></svg> ${rating}</span>-->
                            <span class="dish-card-likes"><svg class="icon icon-sm icon-danger icon-filled"><use href="#icon-heart-filled"></use></svg> ${likes} likes</span>
                        </div>
                    </div>
                </article>
            `;
        }).join('');
        
        grid.style.display = 'grid';
    }
    
    // Render pagination
    function renderPagination() {
        if (totalPages <= 1) {
            if (totalDishes > 0) {
                pagination.innerHTML = `<span style="color: var(--text-muted);">Showing all ${totalDishes} dish(es)</span>`;
                pagination.style.display = 'flex';
            } else {
                pagination.style.display = 'none';
            }
            return;
        }
        
        pagination.style.display = 'flex';
        let html = '';
        
        // Previous button
        html += `<button class="pagination-btn" onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>← Prev</button>`;
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                html += `<button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>`;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                html += '<span style="padding: 0 0.5rem; color: var(--text-muted);">...</span>';
            }
        }
        
        // Next button
        html += `<button class="pagination-btn" onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>Next →</button>`;
        
        // Info
        html += `<span style="margin-left: 1rem; color: var(--text-muted);">Page ${currentPage} of ${totalPages} (${totalDishes} dishes)</span>`;
        
        pagination.innerHTML = html;
    }
    
    // Go to page function (global)
    window.goToPage = function(page) {
        if (page < 1 || page > totalPages) return;
        loadDishes(page);
        document.getElementById('dishes-grid').scrollIntoView({ behavior: 'smooth' });
    };
    
    // Load restaurant count
    async function loadRestaurantCount() {
        try {
            const response = await fetch('/api/restaurants');
            const result = await response.json();
            const restaurants = result.data || result;
            document.getElementById('total-restaurants').textContent = Array.isArray(restaurants) ? restaurants.length : 0;
        } catch (error) {
            console.error('Error loading restaurants:', error);
        }
    }
    
    // Event listeners
    categorySelect.addEventListener('change', () => loadDishes(1));
    citySelect.addEventListener('change', () => loadDishes(1));
    sortSelect.addEventListener('change', () => loadDishes(1));
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadDishes(1), 300);
    });
    
    // Initial load
    loadCategories();
    loadRestaurantCount();
    loadDishes();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/dishes.blade.php ENDPATH**/ ?>