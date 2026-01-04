<?php $__env->startSection('meta_title', 'Popular Dishes - ' . ($seoSettings['site_name'] ?? 'FOODCITA')); ?>
<?php $__env->startSection('meta_description', 'Discover the most popular dishes loved by food enthusiasts. Explore top-rated meals from the best restaurants.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .popular-hero {
        text-align: center;
        padding: 3rem 0 2rem;
    }
    
    .popular-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: var(--text-dark);
    }
    
    .popular-subtitle {
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
    
    .filter-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        background: #fff;
        cursor: pointer;
    }
    
    .filter-group select:focus {
        outline: none;
        border-color: var(--primary);
    }
    
    .dishes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .dish-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    
    .dish-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    
    .dish-card-rank {
        position: absolute;
        top: 12px;
        left: 12px;
        width: 36px;
        height: 36px;
        background: var(--primary);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    .dish-card-rank.gold {
        background: linear-gradient(135deg, #ffd700, #ffb700);
        color: #000;
    }
    
    .dish-card-rank.silver {
        background: linear-gradient(135deg, #c0c0c0, #a8a8a8);
        color: #000;
    }
    
    .dish-card-rank.bronze {
        background: linear-gradient(135deg, #cd7f32, #b87333);
        color: #fff;
    }
    
    .dish-card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f1f5f9;
    }
    
    .dish-card-body {
        padding: 1.25rem;
    }
    
    .dish-card-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        color: var(--text-dark);
    }
    
    .dish-card-restaurant {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0 0 0.75rem 0;
    }
    
    .dish-card-stats {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .dish-stat {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    
    .dish-stat .icon {
        width: 16px;
        height: 16px;
    }
    
    .dish-stat.likes {
        color: #ef4444;
    }
    
    .dish-stat.rating {
        color: #f59e0b;
    }
    
    .dish-stat.reviews {
        color: #3b82f6;
    }
    
    .popularity-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        background: rgba(232, 93, 4, 0.1);
        color: var(--primary);
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.75rem;
    }
    
    .loader {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 200px;
    }
    
    .loader-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e2e8f0;
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
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
        color: var(--text-muted);
    }
    
    .empty-state-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .empty-state-text {
        color: var(--text-muted);
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin-top: 2rem;
        padding: 1rem 0;
    }
    
    .pagination-btn {
        padding: 0.5rem 1rem;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .pagination-btn:hover:not(.disabled) {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    
    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .pagination-pages {
        display: flex;
        gap: 0.25rem;
    }
    
    .pagination-page {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .pagination-page:hover {
        border-color: var(--primary);
    }
    
    .pagination-page.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section class="popular-hero">
        <h1 class="popular-title">🔥 Popular Dishes</h1>
        <p class="popular-subtitle">The most loved dishes based on likes and reviews from our community</p>
        
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value" id="total-dishes">-</div>
                <div class="stat-label">Popular Dishes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="total-likes">-</div>
                <div class="stat-label">Total Likes</div>
            </div>
            <div class="stat-item" style="display:none;">
                <div class="stat-value" id="total-reviews">-</div>
                <div class="stat-label">Total Reviews</div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Category</label>
                <select id="filter-category">
                    <option value="">All Categories</option>
                </select>
            </div>
            <div class="filter-group">
                <label>City</label>
                <select id="filter-city">
                    <option value="">All Cities</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Dishes Grid -->
    <section>
        <div id="dishes-loader" class="loader">
            <div class="loader-spinner"></div>
        </div>
        
        <div id="dishes-grid" class="dishes-grid" style="display: none;"></div>
        
        <div id="dishes-empty" class="empty-state" style="display: none;">
            <div class="empty-state-icon">🍽️</div>
            <h3 class="empty-state-title">No popular dishes yet</h3>
            <p class="empty-state-text">Be the first to like and review dishes!</p>
        </div>
        
        <!-- Pagination -->
        <div id="pagination-container"></div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let lastPage = 1;
    let allDishes = [];
    let categories = [];
    let cities = new Set();
    
    const dishesGrid = document.getElementById('dishes-grid');
    const dishesLoader = document.getElementById('dishes-loader');
    const dishesEmpty = document.getElementById('dishes-empty');
    const paginationContainer = document.getElementById('pagination-container');
    
    const filterCategory = document.getElementById('filter-category');
    const filterCity = document.getElementById('filter-city');
    
    // Load categories
    async function loadCategories() {
        try {
            const res = await fetch('/api/categories');
            const result = await res.json();
            categories = result.data || result;
            
            filterCategory.innerHTML = '<option value="">All Categories</option>';
            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.slug;
                option.textContent = cat.name;
                filterCategory.appendChild(option);
            });
        } catch (e) {
            console.error('Failed to load categories:', e);
        }
    }
    
    // Load popular dishes
    async function loadDishes(page = 1) {
        dishesLoader.style.display = 'flex';
        dishesGrid.style.display = 'none';
        dishesEmpty.style.display = 'none';
        paginationContainer.innerHTML = '';
        
        try {
            const params = new URLSearchParams();
            params.set('page', page);
            params.set('per_page', 12);
            
            if (filterCategory.value) params.set('category', filterCategory.value);
            if (filterCity.value) params.set('city', filterCity.value);
            
            const res = await fetch('/api/popular?' + params.toString());
            const data = await res.json();
            
            allDishes = data.data || [];
            currentPage = data.current_page || 1;
            lastPage = data.last_page || 1;
            
            // Extract cities for filter
            allDishes.forEach(dish => {
                if (dish.restaurant && dish.restaurant.city) {
                    cities.add(dish.restaurant.city);
                }
            });
            updateCitiesFilter();
            
            // Update stats
            updateStats();
            
            renderDishes();
            renderPagination();
            
        } catch (e) {
            console.error('Failed to load dishes:', e);
            dishesLoader.style.display = 'none';
            dishesEmpty.style.display = 'block';
        }
    }
    
    function updateStats() {
        const totalLikes = allDishes.reduce((sum, dish) => sum + (dish.likes_count || 0), 0);
        const totalReviews = allDishes.reduce((sum, dish) => sum + (dish.reviews_count || 0), 0);
        
        document.getElementById('total-dishes').textContent = allDishes.length;
        document.getElementById('total-likes').textContent = totalLikes;
        document.getElementById('total-reviews').textContent = totalReviews;
    }
    
    function updateCitiesFilter() {
        const currentValue = filterCity.value;
        filterCity.innerHTML = '<option value="">All Cities</option>';
        
        Array.from(cities).sort().forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            if (city === currentValue) option.selected = true;
            filterCity.appendChild(option);
        });
    }
    
    function getRankClass(index) {
        if (index === 0) return 'gold';
        if (index === 1) return 'silver';
        if (index === 2) return 'bronze';
        return '';
    }
    
    function calculatePopularityScore(dish) {
        const likes = dish.likes_count || 0;
        const reviews = dish.reviews_count || 0;
        const rating = parseFloat(dish.reviews_avg_rating || 0);
        return (likes * 2) + reviews + rating;
    }
    
    function renderDishes() {
        dishesLoader.style.display = 'none';
        
        if (allDishes.length === 0) {
            dishesGrid.style.display = 'none';
            dishesEmpty.style.display = 'block';
            return;
        }
        
        const startRank = (currentPage - 1) * 12;
        
        dishesGrid.innerHTML = allDishes.map((dish, index) => {
            // Find primary image or use first one
            let primaryImage = null;
            if (dish.images && dish.images.length > 0) {
                primaryImage = dish.images.find(img => img.is_primary) || dish.images[0];
            }
            let image = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';
            if (primaryImage) {
                // Check if path is already an absolute URL
                image = primaryImage.path.startsWith('http') 
                    ? primaryImage.path 
                    : '/storage/' + primaryImage.path;
            }
            
            const rating = dish.reviews_avg_rating ? parseFloat(dish.reviews_avg_rating).toFixed(1) : 'N/A';
            const likes = dish.likes_count || 0;
            const reviews = dish.reviews_count || 0;
            const city = dish.restaurant ? dish.restaurant.city : '';
            const restaurant = dish.restaurant ? dish.restaurant.name : 'Unknown Restaurant';
            const rank = startRank + index + 1;
            const rankClass = currentPage === 1 ? getRankClass(index) : '';
            const popularityScore = calculatePopularityScore(dish);
            
            return `
                <article class="dish-card">
                    <div class="dish-card-rank ${rankClass}">#${rank}</div>
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
                        <div class="dish-card-stats">
                            <span class="dish-stat likes">
                                <svg class="icon"><use href="#icon-heart-filled"></use></svg>
                                ${likes} likes
                            </span>
                           <!-- <span class="dish-stat rating">
                                <svg class="icon"><use href="#icon-star-filled"></use></svg>
                                ${rating}
                            </span>
                            <span class="dish-stat reviews">
                                <svg class="icon"><use href="#icon-comment"></use></svg>
                                ${reviews} reviews
                            </span> -->
                        </div>
                    </div>
                </article>
            `;
        }).join('');
        
        dishesGrid.style.display = 'grid';
        dishesEmpty.style.display = 'none';
    }
    
    function renderPagination() {
        if (lastPage <= 1) {
            if (allDishes.length > 0) {
                paginationContainer.innerHTML = '<div class="pagination"><span style="color: var(--text-muted); font-size: 0.875rem;">Showing all ' + allDishes.length + ' dish(es)</span></div>';
            } else {
                paginationContainer.innerHTML = '';
            }
            return;
        }
        
        let html = '<div class="pagination">';
        
        // Previous button
        html += `<button class="pagination-btn ${currentPage === 1 ? 'disabled' : ''}" 
                 onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                 ← Prev</button>`;
        
        // Page numbers
        html += '<div class="pagination-pages">';
        for (let i = 1; i <= lastPage; i++) {
            if (i === 1 || i === lastPage || (i >= currentPage - 1 && i <= currentPage + 1)) {
                html += `<button class="pagination-page ${i === currentPage ? 'active' : ''}" 
                         onclick="goToPage(${i})">${i}</button>`;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                html += '<span style="padding: 0 0.5rem; color: var(--text-muted);">...</span>';
            }
        }
        html += '</div>';
        
        // Next button
        html += `<button class="pagination-btn ${currentPage === lastPage ? 'disabled' : ''}" 
                 onclick="goToPage(${currentPage + 1})" ${currentPage === lastPage ? 'disabled' : ''}>
                 Next →</button>`;
        
        html += '</div>';
        paginationContainer.innerHTML = html;
    }
    
    window.goToPage = function(page) {
        if (page < 1 || page > lastPage) return;
        loadDishes(page);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
    
    // Event listeners
    filterCategory.addEventListener('change', () => {
        currentPage = 1;
        loadDishes();
    });
    
    filterCity.addEventListener('change', () => {
        currentPage = 1;
        loadDishes();
    });
    
    // Initial load
    loadCategories();
    loadDishes();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/popular.blade.php ENDPATH**/ ?>