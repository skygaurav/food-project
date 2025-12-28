@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <h1 class="hero-title">Discover Delicious Dishes</h1>
        <p class="hero-subtitle">Share your favorite meals and explore dishes loved by food enthusiasts in your city</p>
        @auth
            <a href="/upload" class="btn btn-primary">
                <svg class="icon"><use href="#icon-camera"></use></svg> Upload a Dish
            </a>
        @else
            <a href="/register" class="btn btn-primary">
                <svg class="icon"><use href="#icon-utensils"></use></svg> Join Our Community
            </a>
        @endauth
    </section>

    <!-- Popular Dishes Section -->
    <section class="home-section" id="popular">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 class="section-title">🔥 Popular Dishes</h2>
            <a href="/popular" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">View All</a>
        </div>
        <div id="popular-loader" class="loader">
            <div class="loader-spinner"></div>
        </div>
        <div id="popular-grid" class="dishes-grid" style="display: none;"></div>
        <div id="popular-empty" style="display: none; text-align: center; padding: 2rem; color: var(--text-muted);">
            No popular dishes yet
        </div>
    </section>

    <!-- Recent Reviews Section -->
    <section class="home-section" id="reviews">
        <div class="section-header" style="margin-bottom: 1.5rem;">
            <h2 class="section-title">⭐ Recent Reviews</h2>
        </div>
        <div id="reviews-loader" class="loader">
            <div class="loader-spinner"></div>
        </div>
        <div id="reviews-grid" class="reviews-grid" style="display: none;"></div>
        <div id="reviews-empty" style="display: none; text-align: center; padding: 2rem; color: var(--text-muted);">
            No reviews yet
        </div>
    </section>

    <!-- Categories Section -->
    <section class="home-section" id="categories">
        <div class="section-header" style="margin-bottom: 1.5rem;">
            <h2 class="section-title">🍽️ Browse by Category</h2>
        </div>
        <div id="categories-grid" class="categories-grid"></div>
    </section>

    <!-- All Dishes Section -->
    <section class="home-section" id="dishes">
        <div class="section-header" style="margin-bottom: 1.5rem;">
            <h2 class="section-title">🥘 All Dishes</h2>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section" style="margin-bottom: 1.5rem;">
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
                <div class="filter-group">
                    <label>Sort By</label>
                    <select id="filter-sort">
                        <option value="">Newest First</option>
                        <option value="top-reviewed">Top Reviewed</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Dishes Grid -->
        <div id="dishes-loader" class="loader">
            <div class="loader-spinner"></div>
        </div>
        
        <div id="dishes-grid" class="dishes-grid" style="display: none;"></div>
        
        <div id="dishes-empty" class="empty-state" style="display: none;">
            <div class="empty-state-icon"><svg class="icon icon-4xl icon-muted"><use href="#icon-dish"></use></svg></div>
            <h3 class="empty-state-title">No dishes found</h3>
            <p class="empty-state-text">Be the first to share a delicious dish!</p>
            @auth
                <a href="/upload" class="btn btn-primary" style="margin-top: 1rem;">Upload a Dish</a>
            @endauth
        </div>
        
        <!-- Load More -->
        <div id="load-more-container" style="text-align: center; margin-top: 2rem; display: none;">
            <button id="load-more-btn" class="btn btn-outline">Load More Dishes</button>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .home-section {
        margin-bottom: 3rem;
    }
    
    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .review-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    
    .review-card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    
    .review-avatar {
        width: 40px;
        height: 40px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #fff;
        font-size: 1rem;
    }
    
    .review-user-info {
        flex: 1;
    }
    
    .review-user-name {
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0;
    }
    
    .review-date {
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    .review-rating {
        display: flex;
        gap: 2px;
    }
    
    .review-dish {
        margin-bottom: 0.5rem;
    }
    
    .review-dish a {
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
    }
    
    .review-dish a:hover {
        text-decoration: underline;
    }
    
    .review-comment {
        font-size: 0.9rem;
        color: var(--text-dark);
        line-height: 1.5;
        margin: 0;
    }
    
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }
    
    .category-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem 1rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .category-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .category-card-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .category-card-name {
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .category-card-count {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .reviews-grid {
            grid-template-columns: 1fr;
        }
        
        .categories-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
</style>
@endpush

@push('scripts')
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
    const loadMoreContainer = document.getElementById('load-more-container');
    const loadMoreBtn = document.getElementById('load-more-btn');
    
    const filterCategory = document.getElementById('filter-category');
    const filterCity = document.getElementById('filter-city');
    const filterSort = document.getElementById('filter-sort');
    
    // Load categories
    async function loadCategories() {
        try {
            const res = await fetch('/api/categories');
            categories = await res.json();
            
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
    
    // Load dishes
    async function loadDishes(append = false) {
        if (!append) {
            dishesLoader.style.display = 'flex';
            dishesGrid.style.display = 'none';
            dishesEmpty.style.display = 'none';
            loadMoreContainer.style.display = 'none';
        } else {
            loadMoreBtn.disabled = true;
            loadMoreBtn.textContent = 'Loading...';
        }
        
        try {
            const params = new URLSearchParams();
            params.set('page', currentPage);
            
            if (filterCategory.value) params.set('category', filterCategory.value);
            if (filterCity.value) params.set('city', filterCity.value);
            if (filterSort.value) params.set('sort', filterSort.value);
            
            const res = await fetch('/api/dishes?' + params.toString());
            const data = await res.json();
            
            if (!append) {
                allDishes = data.data || [];
            } else {
                allDishes = [...allDishes, ...(data.data || [])];
            }
            
            lastPage = data.last_page || 1;
            
            // Extract cities for filter
            allDishes.forEach(dish => {
                if (dish.restaurant && dish.restaurant.city) {
                    cities.add(dish.restaurant.city);
                }
            });
            updateCitiesFilter();
            
            renderDishes();
            
        } catch (e) {
            console.error('Failed to load dishes:', e);
            dishesLoader.style.display = 'none';
            dishesEmpty.style.display = 'block';
        }
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
    
    function renderDishes() {
        dishesLoader.style.display = 'none';
        
        if (allDishes.length === 0) {
            dishesGrid.style.display = 'none';
            dishesEmpty.style.display = 'block';
            loadMoreContainer.style.display = 'none';
            return;
        }
        
        dishesGrid.innerHTML = allDishes.map(dish => {
            // Find primary image or use first one
            let primaryImage = null;
            if (dish.images && dish.images.length > 0) {
                primaryImage = dish.images.find(img => img.is_primary) || dish.images[0];
            }
            let image = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';
            if (primaryImage) {
                image = primaryImage.path.startsWith('http') ? primaryImage.path : '/storage/' + primaryImage.path;
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
                            <span class="dish-card-rating"><svg class="icon icon-sm icon-warning icon-filled"><use href="#icon-star-filled"></use></svg> ${rating}</span>
                            <span class="dish-card-likes"><svg class="icon icon-sm icon-danger icon-filled"><use href="#icon-heart-filled"></use></svg> ${likes} likes</span>
                        </div>
                    </div>
                </article>
            `;
        }).join('');
        
        dishesGrid.style.display = 'grid';
        dishesEmpty.style.display = 'none';
        
        // Show/hide load more button
        if (currentPage < lastPage) {
            loadMoreContainer.style.display = 'block';
            loadMoreBtn.disabled = false;
            loadMoreBtn.textContent = 'Load More Dishes';
        } else {
            loadMoreContainer.style.display = 'none';
        }
    }
    
    // Event listeners
    filterCategory.addEventListener('change', () => {
        currentPage = 1;
        loadDishes();
    });
    
    filterCity.addEventListener('change', () => {
        currentPage = 1;
        loadDishes();
    });
    
    filterSort.addEventListener('change', () => {
        currentPage = 1;
        loadDishes();
    });
    
    loadMoreBtn.addEventListener('click', () => {
        currentPage++;
        loadDishes(true);
    });
    
    // Load popular dishes
    async function loadPopularDishes() {
        const popularGrid = document.getElementById('popular-grid');
        const popularLoader = document.getElementById('popular-loader');
        const popularEmpty = document.getElementById('popular-empty');
        
        try {
            const res = await fetch('/api/dishes/popular?per_page=4');
            const data = await res.json();
            const dishes = data.data || [];
            
            popularLoader.style.display = 'none';
            
            if (dishes.length === 0) {
                popularEmpty.style.display = 'block';
                return;
            }
            
            popularGrid.innerHTML = dishes.map((dish, index) => {
                let primaryImage = null;
                if (dish.images && dish.images.length > 0) {
                    primaryImage = dish.images.find(img => img.is_primary) || dish.images[0];
                }
                let image = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';
                if (primaryImage) {
                    image = primaryImage.path.startsWith('http') ? primaryImage.path : '/storage/' + primaryImage.path;
                }
                const rating = dish.reviews_avg_rating ? parseFloat(dish.reviews_avg_rating).toFixed(1) : 'N/A';
                const likes = dish.likes_count || 0;
                const restaurant = dish.restaurant ? dish.restaurant.name : 'Unknown Restaurant';
                const rankBadge = index < 3 ? ['🥇', '🥈', '🥉'][index] : `#${index + 1}`;
                
                return `
                    <article class="dish-card" style="position: relative;">
                        <div style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.7); color: #fff; padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.85rem; z-index: 1;">${rankBadge}</div>
                        <a href="/dishes/${dish.slug}">
                            <img src="${image}" alt="${dish.name}" class="dish-card-image" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80'" />
                        </a>
                        <div class="dish-card-body">
                            <a href="/dishes/${dish.slug}" style="text-decoration: none; color: inherit;">
                                <h3 class="dish-card-title">${dish.name}</h3>
                            </a>
                            <p class="dish-card-restaurant">${restaurant}</p>
                            <div class="dish-card-meta">
                                <span class="dish-card-rating"><svg class="icon icon-sm icon-warning icon-filled"><use href="#icon-star-filled"></use></svg> ${rating}</span>
                                <span class="dish-card-likes"><svg class="icon icon-sm icon-danger icon-filled"><use href="#icon-heart-filled"></use></svg> ${likes}</span>
                            </div>
                        </div>
                    </article>
                `;
            }).join('');
            
            popularGrid.style.display = 'grid';
            
        } catch (e) {
            console.error('Failed to load popular dishes:', e);
            popularLoader.style.display = 'none';
            popularEmpty.style.display = 'block';
        }
    }
    
    // Load recent reviews
    async function loadRecentReviews() {
        const reviewsGrid = document.getElementById('reviews-grid');
        const reviewsLoader = document.getElementById('reviews-loader');
        const reviewsEmpty = document.getElementById('reviews-empty');
        
        try {
            const res = await fetch('/api/reviews/recent?limit=6');
            const reviews = await res.json();
            
            reviewsLoader.style.display = 'none';
            
            if (reviews.length === 0) {
                reviewsEmpty.style.display = 'block';
                return;
            }
            
            reviewsGrid.innerHTML = reviews.map(review => {
                const userName = review.user?.name || 'Anonymous';
                const userInitial = userName.charAt(0).toUpperCase();
                const date = new Date(review.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
                const dishName = review.dish?.name || 'Unknown Dish';
                const dishSlug = review.dish?.slug || '';
                
                return `
                    <div class="review-card">
                        <div class="review-card-header">
                            <div class="review-avatar">${userInitial}</div>
                            <div class="review-user-info">
                                <p class="review-user-name">${userName}</p>
                                <span class="review-date">${date}</span>
                            </div>
                            <div class="review-rating" style="color: #f59e0b;">${stars}</div>
                        </div>
                        <div class="review-dish">
                            Reviewed <a href="/dishes/${dishSlug}">${dishName}</a>
                        </div>
                        ${review.comment ? `<p class="review-comment">"${review.comment}"</p>` : ''}
                    </div>
                `;
            }).join('');
            
            reviewsGrid.style.display = 'grid';
            
        } catch (e) {
            console.error('Failed to load reviews:', e);
            reviewsLoader.style.display = 'none';
            reviewsEmpty.style.display = 'block';
        }
    }
    
    // Load categories with icons
    async function loadCategoriesGrid() {
        const categoriesGrid = document.getElementById('categories-grid');
        
        const categoryIcons = {
            'italian': '🍕',
            'mexican': '🌮',
            'asian': '🍜',
            'american': '🍔',
            'seafood': '🦐',
            'indian': '🍛',
            'chinese': '🥡',
            'japanese': '🍣',
            'thai': '🍲',
            'mediterranean': '🥗',
            'french': '🥐',
            'default': '🍽️'
        };
        
        try {
            const res = await fetch('/api/categories');
            const cats = await res.json();
            
            if (cats.length === 0) {
                categoriesGrid.innerHTML = '<p style="color: var(--text-muted);">No categories available</p>';
                return;
            }
            
            categoriesGrid.innerHTML = cats.map(cat => {
                const icon = categoryIcons[cat.slug] || categoryIcons['default'];
                return `
                    <a href="/#dishes" class="category-card" onclick="document.getElementById('filter-category').value='${cat.slug}'; document.getElementById('filter-category').dispatchEvent(new Event('change'));">
                        <div class="category-card-icon">${icon}</div>
                        <div class="category-card-name">${cat.name}</div>
                    </a>
                `;
            }).join('');
            
        } catch (e) {
            console.error('Failed to load categories grid:', e);
            categoriesGrid.innerHTML = '<p style="color: var(--text-muted);">Failed to load categories</p>';
        }
    }
    
    // Initial load
    loadCategories();
    loadDishes();
    loadPopularDishes();
    loadRecentReviews();
    loadCategoriesGrid();
});
</script>
@endpush
