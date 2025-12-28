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

    <!-- Filter Section -->
    <section class="filter-section" id="dishes">
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
    </section>

    <!-- Dishes Grid -->
    <section>
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
            const image = primaryImage 
                ? '/storage/' + primaryImage.path 
                : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';
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
    
    // Initial load
    loadCategories();
    loadDishes();
});
</script>
@endpush
