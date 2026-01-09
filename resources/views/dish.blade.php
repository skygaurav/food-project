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
        background: linear-gradient(135deg, #fef3e2 0%, #fde8d0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 300px;
        max-height: 500px;
    }
    
    .dish-main-image {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
        cursor: pointer;
        transition: transform 0.3s;
    }
    
    .dish-main-image:hover {
        transform: scale(1.02);
    }
    
    .dish-thumbnails {
        display: flex;
        gap: 0.5rem;
        padding: 0.75rem 0;
        margin-top: 0.75rem;
        overflow-x: auto;
        scrollbar-width: none;
        justify-content: center;
    }
    
    .dish-thumbnails::-webkit-scrollbar {
        display: none;
    }
    
    .dish-thumbnail {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        border: 3px solid #e2e8f0;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    
    .dish-thumbnail.active {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(235, 82, 2, 0.3);
    }
    
    .dish-thumbnail:hover {
        border-color: var(--primary);
        opacity: 0.8;
    }
    
    .image-counter {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(0,0,0,0.6);
        color: #fff;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .image-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        color: #fff;
        border: none;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
        z-index: 10;
    }
    
    .image-nav-btn:hover {
        background: rgba(0,0,0,0.8);
    }
    
    .image-nav-btn.prev {
        left: 1rem;
    }
    
    .image-nav-btn.next {
        right: 1rem;
    }
    
    /* Image Modal/Lightbox */
    .image-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .image-modal.show {
        display: flex;
    }
    
    .image-modal-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .image-modal-img {
        max-width: 90vw;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 8px;
        transition: transform 0.3s ease;
        cursor: zoom-in;
    }
    
    .image-modal-img.zoomed {
        cursor: zoom-out;
        transform: scale(2);
        cursor: grab;
    }
    
    .image-modal-img.zoomed.grabbing {
        cursor: grabbing;
    }
    
    .zoom-controls {
        position: absolute;
        bottom: -45px;
        right: 0;
        display: flex;
        gap: 0.5rem;
    }
    
    .zoom-btn {
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: background 0.2s;
    }
    
    .zoom-btn:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .image-modal-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: none;
        border: none;
        color: #fff;
        font-size: 2rem;
        cursor: pointer;
        padding: 0.5rem;
    }
    
    .image-modal-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    
    .image-modal-nav:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .image-modal-nav.prev {
        left: -70px;
    }
    
    .image-modal-nav.next {
        right: -70px;
    }
    
    .image-modal-counter {
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        font-size: 0.9rem;
    }
    
    .image-modal-thumbnails {
        position: absolute;
        bottom: -100px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 0.5rem;
        max-width: 80vw;
        overflow-x: auto;
        padding: 0.5rem;
    }
    
    .image-modal-thumb {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        opacity: 0.6;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    
    .image-modal-thumb.active,
    .image-modal-thumb:hover {
        border-color: #fff;
        opacity: 1;
    }
    
    @media (max-width: 768px) {
        .image-modal-nav.prev {
            left: 1rem;
        }
        
        .image-modal-nav.next {
            right: 1rem;
        }
        
        .image-modal-thumbnails {
            display: none;
        }
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
        margin: 0 0 .5rem 0;
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
    
    .dish-action-btn.active {
        border-color: var(--primary);
        background: var(--primary);
        color: #fff;
    }
    
    .dish-action-btn.active:hover {
        opacity: 0.9;
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
            <div>
                <div class="dish-image-container">
                    <img id="dish-main-image" src="" alt="" class="dish-main-image" onclick="openGalleryModal(currentImageIndex)" />
                    <div id="image-counter" class="image-counter" style="display: none;">1 / 1</div>
                    <button id="prev-btn" class="image-nav-btn prev" style="display: none;" onclick="navigateImage(-1)">
                        <svg class="icon" style="color: #fff;"><use href="#icon-chevron-left"></use></svg>
                    </button>
                    <button id="next-btn" class="image-nav-btn next" style="display: none;" onclick="navigateImage(1)">
                        <svg class="icon" style="color: #fff;"><use href="#icon-chevron-right"></use></svg>
                    </button>
                </div>
                <div id="dish-thumbnails" class="dish-thumbnails" style="display: none;"></div>
            </div>
            
            <div class="dish-info">
                <h1 id="dish-title" class="dish-title"></h1>
                <p id="dish-restaurant" class="dish-restaurant"></p>
                <p id="dish-location" class="dish-location"></p>
                <p id="dish-opening-hours" class="dish-location dish-location"></p>
                
                <div class="dish-stats">
                    <div class="dish-stat" style="display: none;">
                        <div id="dish-rating" class="dish-stat-value">-</div>
                        <div class="dish-stat-label">Rating</div>
                    </div>
                    <div class="dish-stat" style="display: none;">
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
                        <div class="dish-detail-label">Reservation</div>
                        <div id="dish-reservation" class="dish-detail-value">-</div>
                    </div>
                    <div class="dish-detail-item">
                        <div class="dish-detail-label">Phone</div>
                        <div id="dish-phone" class="dish-detail-value">-</div>
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
                    <button id="dislike-btn" class="dish-action-btn" style="display: none;">
                        <svg class="icon" style="transform: scaleY(-1)"><use href="#icon-thumbs-up"></use></svg> Dislike
                    </button>
                </div>
            </div>
        </section>
        
        <!-- Reviews Section -->
        <section class="reviews-section" style="display: none;">
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
    
    <!-- Image Gallery Modal -->
    <div id="gallery-modal" class="image-modal">
        <div class="image-modal-content">
            <button class="image-modal-close" onclick="closeGalleryModal()">&times;</button>
            <button class="image-modal-nav prev" onclick="modalNavigate(-1)">
                <svg class="icon" style="color: #fff;"><use href="#icon-chevron-left"></use></svg>
            </button>
            <img id="modal-main-image" class="image-modal-img" src="" alt="" onclick="toggleZoom(event)" />
            <button class="image-modal-nav next" onclick="modalNavigate(1)">
                <svg class="icon" style="color: #fff;"><use href="#icon-chevron-right"></use></svg>
            </button>
            <div id="modal-counter" class="image-modal-counter">1 / 1</div>
            <div class="zoom-controls">
                <button class="zoom-btn" onclick="zoomIn()" title="Zoom In">+</button>
                <button class="zoom-btn" onclick="zoomOut()" title="Zoom Out">−</button>
                <button class="zoom-btn" onclick="resetZoom()" title="Reset">↺</button>
            </div>
            <div id="modal-thumbnails" class="image-modal-thumbnails"></div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dishSlug = window.location.pathname.split('/').pop();
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    
    const loader = document.getElementById('dish-loader');
    const content = document.getElementById('dish-content');
    const error = document.getElementById('dish-error');
    
    let currentDish = null;
    let currentImageIndex = 0;
    
    async function loadDish() {
        try {
            const res = await fetch(`/api/dishes/${dishSlug}`);
            if (!res.ok) throw new Error('Dish not found');
            
            currentDish = await res.json();
            renderDish();
            loadRelatedDishes();
            setupReactionButtons();
            
        } catch (e) {
            console.error('Failed to load dish:', e);
            loader.style.display = 'none';
            error.style.display = 'block';
        }
    }
    
    function setupReactionButtons() {
        const likeBtn = document.getElementById('like-btn');
        const dislikeBtn = document.getElementById('dislike-btn');
        
        if (!isAuthenticated) {
            likeBtn.addEventListener('click', () => window.location.href = '/login');
            dislikeBtn.addEventListener('click', () => window.location.href = '/login');
            return;
        }
        
        // Update button states based on user's reaction
        updateReactionButtons();
        
        likeBtn.addEventListener('click', () => handleReaction('like'));
        dislikeBtn.addEventListener('click', () => handleReaction('dislike'));
    }
    
    function updateReactionButtons() {
        const likeBtn = document.getElementById('like-btn');
        const dislikeBtn = document.getElementById('dislike-btn');
        
        likeBtn.classList.remove('active');
        dislikeBtn.classList.remove('active');
        
        if (currentDish.user_reaction === 'like') {
            likeBtn.classList.add('active');
        } else if (currentDish.user_reaction === 'dislike') {
            dislikeBtn.classList.add('active');
        }
        
        // Update counts
        document.getElementById('dish-likes').textContent = currentDish.likes_count || 0;
    }
    
    async function handleReaction(type) {
        try {
            const res = await fetch(`/api/dishes/${dishSlug}/reactions`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type })
            });
            
            if (!res.ok) {
                if (res.status === 401) {
                    window.location.href = '/login';
                    return;
                }
                throw new Error('Failed to update reaction');
            }
            
            const data = await res.json();
            currentDish.user_reaction = data.reaction?.type || null;
            currentDish.likes_count = data.likes_count;
            currentDish.dislikes_count = data.dislikes_count;
            updateReactionButtons();
            
        } catch (e) {
            console.error('Failed to update reaction:', e);
            alert('Failed to update reaction. Please try again.');
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
            currentImageIndex = 0;
            
            // Show image counter and navigation for multiple images
            if (dish.images.length > 1) {
                document.getElementById('image-counter').style.display = 'block';
                document.getElementById('image-counter').textContent = `1 / ${dish.images.length}`;
                document.getElementById('prev-btn').style.display = 'flex';
                document.getElementById('next-btn').style.display = 'flex';
                
                // Thumbnails
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
            
            // Opening hours (from restaurant)
            if (dish.restaurant.opening_hours) {
                document.getElementById('dish-opening-hours').textContent = 'Opening Hours: ' + dish.restaurant.opening_hours;
            }
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
        
        // Date Spot: Pull from Restaurant first, then fall back to dish
        const isDateSpot = (dish.restaurant && dish.restaurant.is_date_spot !== null && dish.restaurant.is_date_spot !== undefined) 
            ? dish.restaurant.is_date_spot 
            : dish.good_date_spot;
        document.getElementById('dish-date-spot').innerHTML = isDateSpot ? 'Yes <svg class="icon icon-sm icon-danger icon-filled"><use href="#icon-heart-filled"></use></svg>' : 'No';
        
        // Reservation: Pull from Restaurant first, then fall back to dish
        const hasReservation = (dish.restaurant && dish.restaurant.reservation !== null && dish.restaurant.reservation !== undefined)
            ? dish.restaurant.reservation
            : dish.reservation;
        document.getElementById('dish-reservation').innerHTML = hasReservation ? 'Yes <svg class="icon icon-sm icon-success"><use href="#icon-check-circle"></use></svg>' : 'No';
        
        // Use dish phone/website, fallback to restaurant phone/website
        const phoneNumber = dish.phone || (dish.restaurant && dish.restaurant.phone);
        document.getElementById('dish-phone').innerHTML = phoneNumber ? `<a href="tel:${phoneNumber}" style="color: var(--primary);">${phoneNumber}</a>` : '-';
        
        const websiteUrl = dish.website || (dish.restaurant && dish.restaurant.website);
        if (websiteUrl) {
            document.getElementById('dish-website').innerHTML = `<a href="${websiteUrl}" target="_blank" style="color: var(--primary);">Visit</a>`;
        }
        
        // Reviews
        //renderReviews(dish.reviews || []);
        
        // Update page title
        document.title = dish.name + ' - FOODCITA';
    }
    
    window.changeImage = function(idx) {
        currentImageIndex = idx;
        const mainImage = document.getElementById('dish-main-image');
        mainImage.src = '/storage/' + currentDish.images[idx].path;
        
        document.querySelectorAll('.dish-thumbnail').forEach((thumb, i) => {
            thumb.classList.toggle('active', i === idx);
        });
        
        // Update counter
        const imageCount = currentDish.images.length;
        if (imageCount > 1) {
            document.getElementById('image-counter').textContent = `${idx + 1} / ${imageCount}`;
        }
    };
    
    // Navigate images with arrow buttons
    window.navigateImage = function(direction) {
        if (!currentDish.images || currentDish.images.length <= 1) return;
        
        const imageCount = currentDish.images.length;
        let newIndex = currentImageIndex + direction;
        
        if (newIndex < 0) newIndex = imageCount - 1;
        if (newIndex >= imageCount) newIndex = 0;
        
        changeImage(newIndex);
    };
    
    // Gallery Modal Functions
    window.openGalleryModal = function(idx) {
        if (!currentDish.images || currentDish.images.length === 0) return;
        
        const modal = document.getElementById('gallery-modal');
        const modalImg = document.getElementById('modal-main-image');
        const modalThumbs = document.getElementById('modal-thumbnails');
        const modalCounter = document.getElementById('modal-counter');
        
        currentImageIndex = idx || 0;
        modalImg.src = '/storage/' + currentDish.images[currentImageIndex].path;
        modalCounter.textContent = `${currentImageIndex + 1} / ${currentDish.images.length}`;
        
        // Render modal thumbnails
        if (currentDish.images.length > 1) {
            modalThumbs.innerHTML = currentDish.images.map((img, i) => `
                <img src="/storage/${img.path}" alt="" class="image-modal-thumb ${i === currentImageIndex ? 'active' : ''}" onclick="modalChangeImage(${i})" />
            `).join('');
        } else {
            modalThumbs.style.display = 'none';
        }
        
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    };
    
    window.closeGalleryModal = function() {
        document.getElementById('gallery-modal').classList.remove('show');
        document.body.style.overflow = '';
        resetZoom();
    };
    
    // Zoom functionality
    let zoomLevel = 1;
    let isDragging = false;
    let dragStart = { x: 0, y: 0 };
    let imgPosition = { x: 0, y: 0 };
    
    window.toggleZoom = function(e) {
        const img = document.getElementById('modal-main-image');
        if (zoomLevel === 1) {
            zoomIn();
        } else {
            resetZoom();
        }
    };
    
    window.zoomIn = function() {
        const img = document.getElementById('modal-main-image');
        zoomLevel = Math.min(zoomLevel + 0.5, 4);
        img.style.transform = `scale(${zoomLevel}) translate(${imgPosition.x}px, ${imgPosition.y}px)`;
        img.classList.toggle('zoomed', zoomLevel > 1);
    };
    
    window.zoomOut = function() {
        const img = document.getElementById('modal-main-image');
        zoomLevel = Math.max(zoomLevel - 0.5, 1);
        if (zoomLevel === 1) {
            resetZoom();
        } else {
            img.style.transform = `scale(${zoomLevel}) translate(${imgPosition.x}px, ${imgPosition.y}px)`;
        }
    };
    
    window.resetZoom = function() {
        const img = document.getElementById('modal-main-image');
        zoomLevel = 1;
        imgPosition = { x: 0, y: 0 };
        img.style.transform = '';
        img.classList.remove('zoomed', 'grabbing');
    };
    
    // Pan/drag functionality when zoomed
    const modalImg = document.getElementById('modal-main-image');
    
    modalImg.addEventListener('mousedown', function(e) {
        if (zoomLevel <= 1) return;
        isDragging = true;
        dragStart = { x: e.clientX - imgPosition.x, y: e.clientY - imgPosition.y };
        this.classList.add('grabbing');
        e.preventDefault();
    });
    
    document.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        imgPosition = {
            x: (e.clientX - dragStart.x) / zoomLevel,
            y: (e.clientY - dragStart.y) / zoomLevel
        };
        modalImg.style.transform = `scale(${zoomLevel}) translate(${imgPosition.x}px, ${imgPosition.y}px)`;
    });
    
    document.addEventListener('mouseup', function() {
        isDragging = false;
        modalImg.classList.remove('grabbing');
    });
    
    // Mouse wheel zoom
    document.getElementById('gallery-modal').addEventListener('wheel', function(e) {
        if (!this.classList.contains('show')) return;
        e.preventDefault();
        if (e.deltaY < 0) {
            zoomIn();
        } else {
            zoomOut();
        }
    });
    
    window.modalNavigate = function(direction) {
        if (!currentDish.images || currentDish.images.length <= 1) return;
        
        const imageCount = currentDish.images.length;
        let newIndex = currentImageIndex + direction;
        
        if (newIndex < 0) newIndex = imageCount - 1;
        if (newIndex >= imageCount) newIndex = 0;
        
        modalChangeImage(newIndex);
    };
    
    window.modalChangeImage = function(idx) {
        currentImageIndex = idx;
        const modalImg = document.getElementById('modal-main-image');
        const modalCounter = document.getElementById('modal-counter');
        
        // Reset zoom when changing images
        resetZoom();
        
        modalImg.src = '/storage/' + currentDish.images[idx].path;
        modalCounter.textContent = `${idx + 1} / ${currentDish.images.length}`;
        
        // Update modal thumbnails
        document.querySelectorAll('.image-modal-thumb').forEach((thumb, i) => {
            thumb.classList.toggle('active', i === idx);
        });
        
        // Also update main page thumbnails
        changeImage(idx);
    };
    
    // Keyboard navigation for modal
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('gallery-modal');
        if (!modal.classList.contains('show')) return;
        
        if (e.key === 'Escape') closeGalleryModal();
        if (e.key === 'ArrowLeft') modalNavigate(-1);
        if (e.key === 'ArrowRight') modalNavigate(1);
    });
    
    // Close modal on backdrop click
    document.getElementById('gallery-modal').addEventListener('click', function(e) {
        if (e.target === this) closeGalleryModal();
    });
    
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
                        <a href="/dishes/${dish.slug}" class="related-card" style="text-decoration: none;">
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
