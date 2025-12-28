@extends('layouts.frontend')

@section('title', 'Dish Details')

@push('styles')
<style>
    .dish-detail {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    @media (min-width: 768px) {
        .dish-detail {
            grid-template-columns: 1.5fr 1fr;
        }
    }
    
    .dish-image-container {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background: #f1f5f9;
    }
    
    .dish-main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
    
    .dish-thumbnails {
        display: flex;
        gap: 0.5rem;
        padding: 0.5rem;
        background: rgba(0,0,0,0.5);
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }
    
    .dish-thumbnail {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.2s;
    }
    
    .dish-thumbnail.active,
    .dish-thumbnail:hover {
        border-color: #fff;
    }
    
    .dish-info {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    
    .dish-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: var(--text-dark);
    }
    
    .dish-restaurant {
        font-size: 1.1rem;
        color: var(--primary);
        margin: 0 0 0.25rem 0;
    }
    
    .dish-location {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0 0 1.5rem 0;
    }
    
    .dish-stats {
        display: flex;
        gap: 1.5rem;
        padding: 1rem 0;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
    }
    
    .dish-stat {
        text-align: center;
    }
    
    .dish-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
    }
    
    .dish-stat-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .dish-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .dish-detail-item {
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 8px;
    }
    
    .dish-detail-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    
    .dish-detail-value {
        font-weight: 500;
        color: var(--text-dark);
    }
    
    .dish-actions {
        display: flex;
        gap: 1rem;
    }
    
    .dish-action-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: 2px solid #e2e8f0;
        background: #fff;
        color: var(--text-dark);
    }
    
    .dish-action-btn:hover {
        border-color: var(--primary);
        background: #fff5eb;
    }
    
    .dish-action-btn.liked {
        border-color: #ef4444;
        background: #fef2f2;
        color: #ef4444;
    }
    
    /* Reviews Section */
    .reviews-section {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    
    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .reviews-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .review-form {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .review-form-row {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 1rem;
        align-items: flex-end;
    }
    
    .review-form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    
    .review-form-group select,
    .review-form-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
    }
    
    .review-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .review-item {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .review-item:last-child {
        border-bottom: none;
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .review-author {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .review-rating {
        color: #f59e0b;
    }
    
    .review-text {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.6;
        margin: 0;
    }
    
    /* Related Dishes */
    .related-section {
        margin-top: 2rem;
    }
    
    .related-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 1rem 0;
    }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .related-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }
    
    .related-card:hover {
        transform: translateY(-2px);
    }
    
    .related-card-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }
    
    .related-card-body {
        padding: 0.75rem;
    }
    
    .related-card-title {
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0 0 0.25rem 0;
        color: var(--text-dark);
    }
    
    .related-card-restaurant {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }
    
    @media (max-width: 768px) {
        .review-form-row {
            grid-template-columns: 1fr;
        }
        
        .dish-actions {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
    <!-- Loader -->
    <div id="dish-loader" class="loader">
        <div class="loader-spinner"></div>
    </div>
    
    <!-- Dish Content -->
    <div id="dish-content" style="display: none;">
        <section class="dish-detail">
            <div class="dish-image-container">
                <img id="dish-main-image" src="" alt="" class="dish-main-image" />
                <div id="dish-thumbnails" class="dish-thumbnails" style="display: none;"></div>
            </div>
            
            <div class="dish-info">
                <h1 id="dish-title" class="dish-title"></h1>
                <p id="dish-restaurant" class="dish-restaurant"></p>
                <p id="dish-location" class="dish-location"></p>
                
                <div class="dish-stats">
                    <div class="dish-stat">
                        <div id="dish-rating" class="dish-stat-value">-</div>
                        <div class="dish-stat-label">Rating</div>
                    </div>
                    <div class="dish-stat">
                        <div id="dish-reviews" class="dish-stat-value">0</div>
                        <div class="dish-stat-label">Reviews</div>
                    </div>
                    <div class="dish-stat">
                        <div id="dish-likes" class="dish-stat-value">0</div>
                        <div class="dish-stat-label">Likes</div>
                    </div>
                </div>
                
                <div class="dish-details-grid">
                    <div class="dish-detail-item">
                        <div class="dish-detail-label">Category</div>
                        <div id="dish-category" class="dish-detail-value">-</div>
                    </div>
                    <div class="dish-detail-item">
                        <div class="dish-detail-label">Meal Cost</div>
                        <div id="dish-cost" class="dish-detail-value">-</div>
                    </div>
                    <div class="dish-detail-item">
                        <div class="dish-detail-label">Date Spot</div>
                        <div id="dish-date-spot" class="dish-detail-value">-</div>
                    </div>
                    <div class="dish-detail-item">
                        <div class="dish-detail-label">Website</div>
                        <div id="dish-website" class="dish-detail-value">-</div>
                    </div>
                </div>
                
                <div class="dish-actions">
                    <button id="like-btn" class="dish-action-btn">
                        <svg class="icon"><use href="#icon-thumbs-up"></use></svg> Like
                    </button>
                    <button id="dislike-btn" class="dish-action-btn">
                        <svg class="icon" style="transform: scaleY(-1)"><use href="#icon-thumbs-up"></use></svg> Dislike
                    </button>
                </div>
            </div>
        </section>
        
        <!-- Comment if any -->
        <div id="dish-comment-section" class="reviews-section" style="display: none;">
            <h3 class="reviews-title">Uploader's Comment</h3>
            <p id="dish-comment" style="color: var(--text-muted); line-height: 1.6;"></p>
        </div>
        
        <!-- Reviews Section -->
        <section class="reviews-section">
            <div class="reviews-header">
                <h3 class="reviews-title">Reviews</h3>
            </div>
            
            @auth
            <form id="review-form" class="review-form">
                <div class="review-form-row">
                    <div class="review-form-group">
                        <label>Rating</label>
                        <select id="review-rating" required>
                            <option value="5">★★★★★ Excellent</option>
                            <option value="4">★★★★ Great</option>
                            <option value="3">★★★ Good</option>
                            <option value="2">★★ Fair</option>
                            <option value="1">★ Poor</option>
                        </select>
                    </div>
                    <div class="review-form-group">
                        <label>Your Review</label>
                        <input type="text" id="review-comment" placeholder="Share your experience with this dish..." required />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 1rem; width: 100%;">Submit Review</button>
            </form>
            @else
            <div style="text-align: center; padding: 1.5rem; background: #f8fafc; border-radius: 12px; margin-bottom: 1.5rem;">
                <p style="margin: 0 0 0.5rem 0; color: var(--text-muted);">Want to leave a review?</p>
                <a href="/login" class="btn btn-primary">Login to Review</a>
            </div>
            @endauth
            
            <div id="reviews-loader" class="loader" style="display: none;">
                <div class="loader-spinner"></div>
            </div>
            
            <div id="reviews-list" class="review-list"></div>
            
            <div id="no-reviews" style="text-align: center; padding: 2rem; color: var(--text-muted); display: none;">
                No reviews yet. Be the first to review this dish!
            </div>
        </section>
        
        <!-- Related Dishes -->
        <section id="related-section" class="related-section" style="display: none;">
            <h3 class="related-title">You Might Also Like</h3>
            <div id="related-grid" class="related-grid"></div>
        </section>
    </div>
    
    <!-- Error State -->
    <div id="dish-error" class="empty-state" style="display: none;">
        <div class="empty-state-icon">😕</div>
        <h3 class="empty-state-title">Dish not found</h3>
        <p class="empty-state-text">The dish you're looking for doesn't exist or has been removed.</p>
        <a href="/" class="btn btn-primary" style="margin-top: 1rem;">Back to Home</a>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dishId = window.location.pathname.split('/').pop();
    
    const loader = document.getElementById('dish-loader');
    const content = document.getElementById('dish-content');
    const error = document.getElementById('dish-error');
    
    let currentDish = null;
    
    async function loadDish() {
        try {
            const res = await fetch(`/api/dishes/${dishId}`);
            if (!res.ok) throw new Error('Dish not found');
            
            currentDish = await res.json();
            renderDish();
            loadRelatedDishes();
            
        } catch (e) {
            console.error('Failed to load dish:', e);
            loader.style.display = 'none';
            error.style.display = 'block';
        }
    }
    
    function renderDish() {
        loader.style.display = 'none';
        content.style.display = 'block';
        
        const dish = currentDish;
        
        // Main image
        const mainImage = document.getElementById('dish-main-image');
        if (dish.images && dish.images.length > 0) {
            mainImage.src = '/storage/' + dish.images[0].path;
            mainImage.alt = dish.name;
            
            // Thumbnails
            if (dish.images.length > 1) {
                const thumbsContainer = document.getElementById('dish-thumbnails');
                thumbsContainer.style.display = 'flex';
                thumbsContainer.innerHTML = dish.images.map((img, idx) => `
                    <img src="/storage/${img.path}" alt="${dish.name}" class="dish-thumbnail ${idx === 0 ? 'active' : ''}" onclick="changeImage(${idx})" />
                `).join('');
            }
        } else {
            mainImage.src = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=900&q=80';
            mainImage.alt = dish.name;
        }
        
        // Title and info
        document.getElementById('dish-title').textContent = dish.name;
        document.getElementById('dish-restaurant').textContent = dish.restaurant ? dish.restaurant.name : 'Unknown Restaurant';
        
        if (dish.restaurant) {
            const location = [dish.restaurant.address, dish.restaurant.city, dish.restaurant.region].filter(Boolean).join(', ');
            document.getElementById('dish-location').textContent = location || '';
        }
        
        // Stats
        document.getElementById('dish-rating').innerHTML = dish.reviews_avg_rating ? '<svg class="icon icon-sm icon-warning icon-filled"><use href="#icon-star-filled"></use></svg> ' + parseFloat(dish.reviews_avg_rating).toFixed(1) : '-';
        document.getElementById('dish-reviews').textContent = dish.reviews ? dish.reviews.length : 0;
        document.getElementById('dish-likes').textContent = dish.reactions ? dish.reactions.filter(r => r.type === 'like').length : 0;
        
        // Details
        if (dish.restaurant && dish.restaurant.categories && dish.restaurant.categories.length > 0) {
            document.getElementById('dish-category').textContent = dish.restaurant.categories.map(c => c.name).join(', ');
        }
        
        document.getElementById('dish-cost').textContent = dish.meal_cost ? '$' + parseFloat(dish.meal_cost).toFixed(2) : '-';
        document.getElementById('dish-date-spot').innerHTML = dish.good_date_spot ? 'Yes <svg class="icon icon-sm icon-danger icon-filled"><use href="#icon-heart-filled"></use></svg>' : 'No';
        
        if (dish.website) {
            document.getElementById('dish-website').innerHTML = `<a href="${dish.website}" target="_blank" style="color: var(--primary);">Visit</a>`;
        }
        
        // Comment
        if (dish.comment) {
            document.getElementById('dish-comment-section').style.display = 'block';
            document.getElementById('dish-comment').textContent = dish.comment;
        }
        
        // Reviews
        renderReviews(dish.reviews || []);
        
        // Update page title
        document.title = dish.name + ' - FOODCITA';
    }
    
    window.changeImage = function(idx) {
        const mainImage = document.getElementById('dish-main-image');
        mainImage.src = '/storage/' + currentDish.images[idx].path;
        
        document.querySelectorAll('.dish-thumbnail').forEach((thumb, i) => {
            thumb.classList.toggle('active', i === idx);
        });
    };
    
    function renderReviews(reviews) {
        const list = document.getElementById('reviews-list');
        const noReviews = document.getElementById('no-reviews');
        
        if (reviews.length === 0) {
            list.innerHTML = '';
            noReviews.style.display = 'block';
            return;
        }
        
        noReviews.style.display = 'none';
        list.innerHTML = reviews.map(review => `
            <div class="review-item">
                <div class="review-header">
                    <span class="review-author">User #${review.user_id || 'Anonymous'}</span>
                    <span class="review-rating">${'★'.repeat(review.rating)}</span>
                </div>
                <p class="review-text">${review.comment || ''}</p>
            </div>
        `).join('');
    }
    
    async function loadRelatedDishes() {
        try {
            const res = await fetch('/api/dishes?per_page=4');
            const data = await res.json();
            const related = (data.data || []).filter(d => d.id !== currentDish.id).slice(0, 4);
            
            if (related.length > 0) {
                const section = document.getElementById('related-section');
                const grid = document.getElementById('related-grid');
                
                grid.innerHTML = related.map(dish => {
                    const image = dish.images && dish.images.length > 0 
                        ? '/storage/' + dish.images[0].path 
                        : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';
                    
                    return `
                        <a href="/dishes/${dish.id}" class="related-card" style="text-decoration: none;">
                            <img src="${image}" alt="${dish.name}" class="related-card-image" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80'" />
                            <div class="related-card-body">
                                <h4 class="related-card-title">${dish.name}</h4>
                                <p class="related-card-restaurant">${dish.restaurant ? dish.restaurant.name : ''}</p>
                            </div>
                        </a>
                    `;
                }).join('');
                
                section.style.display = 'block';
            }
        } catch (e) {
            console.error('Failed to load related dishes:', e);
        }
    }
    
    // Load dish
    loadDish();
});
</script>
@endpush
