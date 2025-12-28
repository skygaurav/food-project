@extends('layouts.frontend')

@section('meta_title', 'My Dishes - ' . ($seoSettings['site_name'] ?? 'FOODCITA'))

@push('styles')
<style>
    .my-dishes-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .my-dishes-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }
    
    .dishes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    /* Pagination styles */
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
    
    .pagination-ellipsis {
        padding: 0 0.5rem;
        color: var(--text-muted);
    }
    
    .dish-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .dish-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    
    .dish-card-image {
        width: 100%;
        height: 180px;
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
        margin: 0 0 0.5rem 0;
        color: var(--text-dark);
    }
    
    .dish-card-restaurant {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0 0 0.75rem 0;
    }
    
    .dish-card-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    
    .dish-status {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .dish-status.pending {
        background: #fef3c7;
        color: #d97706;
    }
    
    .dish-status.approved {
        background: #d1fae5;
        color: #059669;
    }
    
    .dish-status.rejected {
        background: #fee2e2;
        color: #dc2626;
    }
    
    .dish-card-actions {
        display: flex;
        gap: 0.5rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .dish-card-actions .btn {
        flex: 1;
        font-size: 0.85rem;
        padding: 0.5rem;
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
        margin-bottom: 0.5rem;
    }
    
    .empty-state-text {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }
    
    /* Edit Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    
    .modal-overlay.show {
        display: flex;
    }
    
    .modal-content {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        margin: 1rem;
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .modal-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--text-muted);
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        display: flex;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        border-top: 1px solid #e2e8f0;
        justify-content: flex-end;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(232, 93, 4, 0.1);
    }
    
    .radio-group {
        display: flex;
        gap: 1.5rem;
    }
    
    .radio-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    /* Image management styles */
    .current-images {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .current-image-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .current-image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .current-image-item.marked-for-removal {
        opacity: 0.4;
    }
    
    .current-image-item.marked-for-removal::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 5px,
            rgba(220, 38, 38, 0.3) 5px,
            rgba(220, 38, 38, 0.3) 10px
        );
    }
    
    .remove-image-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 24px;
        height: 24px;
        background: rgba(220, 38, 38, 0.9);
        color: #fff;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        line-height: 1;
    }
    
    .remove-image-btn:hover {
        background: #dc2626;
    }
    
    .undo-remove-btn {
        background: rgba(34, 197, 94, 0.9);
    }
    
    .undo-remove-btn:hover {
        background: #22c55e;
    }
    
    .image-upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }
    
    .image-upload-area:hover {
        border-color: var(--primary);
        background: rgba(232, 93, 4, 0.05);
    }
    
    .image-upload-area.dragover {
        border-color: var(--primary);
        background: rgba(232, 93, 4, 0.1);
    }
    
    .new-images-preview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 0.5rem;
        margin-top: 0.75rem;
    }
    
    .new-image-preview {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .new-image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Categories multiselect styles */
    .categories-select {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0.75rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        min-height: 50px;
    }
    
    .category-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        background: #e2e8f0;
        border: 2px solid transparent;
        border-radius: 20px;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        user-select: none;
    }
    
    .category-chip:hover {
        background: #d1d5db;
    }
    
    .category-chip.selected {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    
    /* Main image indicator */
    .current-image-item.is-main {
        border: 3px solid var(--primary);
    }
    
    .current-image-item.is-main::before {
        content: '★ Main';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--primary);
        color: #fff;
        font-size: 0.65rem;
        text-align: center;
        padding: 2px;
        z-index: 1;
    }
    
    .new-image-preview.is-main {
        border: 3px solid var(--primary);
    }
    
    .new-image-preview.is-main::before {
        content: '★ Main';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--primary);
        color: #fff;
        font-size: 0.65rem;
        text-align: center;
        padding: 2px;
        z-index: 1;
    }
    
    .loader {
        text-align: center;
        padding: 4rem;
    }
    
    .loader-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e2e8f0;
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
    <div class="my-dishes-header">
        <h1 class="my-dishes-title">My Dishes</h1>
        <a href="/upload" class="btn btn-primary">
            <svg class="icon"><use href="#icon-plus"></use></svg> Upload New Dish
        </a>
    </div>
    
    <div id="dishes-loader" class="loader">
        <div class="loader-spinner"></div>
    </div>
    
    <div id="dishes-container" style="display: none;">
        <div id="dishes-grid" class="dishes-grid"></div>
        
        <div id="pagination-container"></div>
        
        <div id="empty-state" class="empty-state" style="display: none;">
            <div class="empty-state-icon">
                <svg class="icon icon-4xl icon-muted"><use href="#icon-dish"></use></svg>
            </div>
            <h3 class="empty-state-title">No dishes yet</h3>
            <p class="empty-state-text">You haven't uploaded any dishes. Share your favorite meals!</p>
            <a href="/upload" class="btn btn-primary">Upload Your First Dish</a>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div id="edit-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Dish</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="edit-form" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="edit-dish-id" />
                    
                    <!-- Image Management Section -->
                    <div class="form-group">
                        <label class="form-label">Images</label>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Click on an image to set it as the main image</p>
                        <div id="current-images" class="current-images"></div>
                        
                        <div class="image-upload-area" id="image-upload-area" onclick="document.getElementById('new-images-input').click()">
                            <svg class="icon icon-lg" style="color: var(--text-muted);"><use href="#icon-camera"></use></svg>
                            <p style="margin: 0.5rem 0 0; color: var(--text-muted); font-size: 0.9rem;">Click to add new images</p>
                        </div>
                        <input type="file" id="new-images-input" multiple accept="image/*" style="display: none;" onchange="handleNewImages(this)" />
                        <div id="new-images-preview" class="new-images-preview"></div>
                        <input type="hidden" id="edit-main-image-id" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Restaurant Categories</label>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Select categories for the restaurant</p>
                        <div id="edit-categories-container" class="categories-select">
                            <span style="color: var(--text-muted); font-size: 0.875rem;">Loading...</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Dish Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="edit-name" class="form-control" />
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Comment</label>
                        <textarea id="edit-comment" class="form-control" rows="3"></textarea>
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Meal Cost ($) <span style="color: #ef4444;">*</span></label>
                        <input type="number" id="edit-meal-cost" class="form-control" step="0.01" min="0" />
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Website</label>
                        <input type="url" id="edit-website" class="form-control" placeholder="https://" />
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" id="edit-phone" class="form-control" />
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Good Date Spot?</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="edit-date-spot" value="1" /> Yes
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="edit-date-spot" value="0" checked /> No
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Accepts Reservations?</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="edit-reservation" value="1" /> Yes
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="edit-reservation" value="0" checked /> No
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="edit-submit-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
let dishes = [];
let currentPage = 1;
let totalPages = 1;
let perPage = 6;

async function loadDishes(page = 1) {
    try {
        document.getElementById('dishes-loader').style.display = 'block';
        document.getElementById('dishes-container').style.display = 'none';
        
        const res = await fetch(`/api/my-dishes?page=${page}&per_page=${perPage}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (!res.ok) throw new Error('Failed to load dishes');
        
        const data = await res.json();
        dishes = data.data || [];
        currentPage = data.meta?.current_page || 1;
        totalPages = data.meta?.last_page || 1;
        
        renderDishes();
        renderPagination();
        
    } catch (e) {
        console.error('Failed to load dishes:', e);
        document.getElementById('dishes-loader').innerHTML = 
            '<p style="color: var(--text-muted);">Failed to load dishes. Please try again.</p>';
    }
}

function getStatusClass(status) {
    return status === 'approved' ? 'approved' : 
           status === 'pending' ? 'pending' : 'rejected';
}

function getStatusIcon(status) {
    if (status === 'approved') return '<svg class="icon icon-sm"><use href="#icon-check-circle"></use></svg>';
    if (status === 'pending') return '<svg class="icon icon-sm"><use href="#icon-clock"></use></svg>';
    return '<svg class="icon icon-sm"><use href="#icon-x"></use></svg>';
}

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('en-US', {
        year: 'numeric', month: 'short', day: 'numeric'
    });
}

function renderDishes() {
    document.getElementById('dishes-loader').style.display = 'none';
    document.getElementById('dishes-container').style.display = 'block';
    
    const grid = document.getElementById('dishes-grid');
    const empty = document.getElementById('empty-state');
    
    if (dishes.length === 0) {
        grid.style.display = 'none';
        empty.style.display = 'block';
        return;
    }
    
    empty.style.display = 'none';
    grid.style.display = 'grid';
    
    grid.innerHTML = dishes.map(dish => {
        const image = dish.image_url || 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';
        const canEdit = dish.status === 'pending';
        
        return `
            <div class="dish-card">
                <img src="${image}" alt="${dish.name}" class="dish-card-image" 
                     onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80'" />
                <div class="dish-card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                        <h3 class="dish-card-title">${dish.name}</h3>
                        <span class="dish-status ${getStatusClass(dish.status)}">
                            ${getStatusIcon(dish.status)} ${dish.status}
                        </span>
                    </div>
                    <p class="dish-card-restaurant">
                        <svg class="icon icon-sm"><use href="#icon-location"></use></svg>
                        ${dish.restaurant ? dish.restaurant.name : 'Unknown Restaurant'}
                    </p>
                    <div class="dish-card-meta">
                        <span><svg class="icon icon-sm"><use href="#icon-clock"></use></svg> ${formatDate(dish.created_at)}</span>
                        ${dish.meal_cost ? `<span>$${parseFloat(dish.meal_cost).toFixed(2)}</span>` : ''}
                    </div>
                    <div class="dish-card-actions">
                        ${dish.status === 'approved' ? `
                            <a href="/dishes/${dish.slug}" class="btn btn-secondary">View</a>
                        ` : dish.status === 'pending' ? `
                            <a href="/dishes/${dish.slug}" class="btn btn-secondary">Preview</a>
                            <button class="btn btn-primary" onclick="openEditModal(${dish.id})">
                                <svg class="icon icon-sm"><use href="#icon-edit"></use></svg> Edit
                            </button>
                            <button class="btn btn-secondary" style="color: #dc2626;" onclick="deleteDish(${dish.id})">
                                <svg class="icon icon-sm"><use href="#icon-trash"></use></svg>
                            </button>
                        ` : `
                            <span style="color: var(--text-muted); font-size: 0.85rem;">This dish was not approved</span>
                        `}
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

function renderPagination() {
    const container = document.getElementById('pagination-container');
    if (!container) return;
    
    if (totalPages <= 1) {
        // Show page info even with single page
        if (dishes.length > 0) {
            container.innerHTML = '<div class="pagination"><span style="color: var(--text-muted); font-size: 0.875rem;">Showing all ' + dishes.length + ' dish(es)</span></div>';
        } else {
            container.innerHTML = '';
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
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
            html += `<button class="pagination-page ${i === currentPage ? 'active' : ''}" 
                     onclick="goToPage(${i})">${i}</button>`;
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            html += '<span class="pagination-ellipsis">...</span>';
        }
    }
    html += '</div>';
    
    // Next button
    html += `<button class="pagination-btn ${currentPage === totalPages ? 'disabled' : ''}" 
             onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
             Next →</button>`;
    
    html += '</div>';
    container.innerHTML = html;
}

function goToPage(page) {
    if (page < 1 || page > totalPages) return;
    loadDishes(page);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

let editMainImageId = null;
let editCategories = [];
let restaurantCategories = [];

function openEditModal(dishId) {
    const dish = dishes.find(d => d.id === dishId);
    if (!dish) return;
    
    currentEditDishId = dishId;
    imagesToRemove = [];
    newImageFiles = [];
    editMainImageId = null;
    
    document.getElementById('edit-dish-id').value = dish.id;
    document.getElementById('edit-name').value = dish.name || '';
    document.getElementById('edit-comment').value = dish.comment || '';
    document.getElementById('edit-meal-cost').value = dish.meal_cost || '';
    document.getElementById('edit-website').value = dish.website || '';
    document.getElementById('edit-phone').value = dish.phone || '';
    
    document.querySelector(`input[name="edit-date-spot"][value="${dish.good_date_spot ? '1' : '0'}"]`).checked = true;
    document.querySelector(`input[name="edit-reservation"][value="${dish.reservation ? '1' : '0'}"]`).checked = true;
    
    // Render current images
    renderCurrentImages(dish);
    
    // Clear new images preview
    document.getElementById('new-images-preview').innerHTML = '';
    document.getElementById('new-images-input').value = '';
    
    // Load categories for edit form
    loadEditCategories(dish.restaurant?.id);
    
    document.getElementById('edit-modal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

async function loadEditCategories(restaurantId) {
    const container = document.getElementById('edit-categories-container');
    
    try {
        // Fetch all categories
        const res = await fetch('/api/categories');
        const result = await res.json();
        const allCategories = result.data || result;
        
        // Get restaurant's current categories if available
        if (restaurantId) {
            const restRes = await fetch(`/api/restaurants/${restaurantId}`);
            const restaurant = await restRes.json();
            restaurantCategories = restaurant.categories?.map(c => c.id) || [];
        } else {
            restaurantCategories = [];
        }
        
        // Render category chips
        container.innerHTML = allCategories.map(cat => {
            const isSelected = restaurantCategories.includes(cat.id);
            return `<span class="category-chip ${isSelected ? 'selected' : ''}" 
                        data-category-id="${cat.id}" 
                        onclick="toggleEditCategory(${cat.id})">${cat.name}</span>`;
        }).join('');
        
        editCategories = [...restaurantCategories];
        
    } catch (err) {
        container.innerHTML = '<span style="color: var(--text-muted); font-size: 0.875rem;">Failed to load categories</span>';
    }
}

function toggleEditCategory(catId) {
    const chip = document.querySelector(`#edit-categories-container .category-chip[data-category-id="${catId}"]`);
    if (!chip) return;
    
    const index = editCategories.indexOf(catId);
    if (index > -1) {
        editCategories.splice(index, 1);
        chip.classList.remove('selected');
    } else {
        editCategories.push(catId);
        chip.classList.add('selected');
    }
}

let currentEditDishId = null;
let imagesToRemove = [];
let newImageFiles = [];

function renderCurrentImages(dish) {
    const container = document.getElementById('current-images');
    const images = dish.images || [];
    
    if (images.length === 0) {
        container.innerHTML = '<p style="color: var(--text-muted); font-size: 0.875rem;">No images uploaded</p>';
        return;
    }
    
    // Find current main image
    const mainImage = images.find(img => img.is_primary);
    if (mainImage && !editMainImageId) {
        editMainImageId = mainImage.id;
    }
    
    container.innerHTML = images.map(img => {
        const isMarked = imagesToRemove.includes(img.id);
        const isMain = editMainImageId === img.id || (!editMainImageId && img.is_primary);
        const imagePath = img.image_path.startsWith('http') ? img.image_path : '/storage/' + img.image_path;
        
        return `
            <div class="current-image-item ${isMarked ? 'marked-for-removal' : ''} ${isMain ? 'is-main' : ''}" 
                 data-image-id="${img.id}"
                 onclick="setEditMainImage(${img.id}, event)">
                <img src="${imagePath}" alt="Dish image" />
                <button type="button" class="${isMarked ? 'remove-image-btn undo-remove-btn' : 'remove-image-btn'}" 
                        onclick="toggleImageRemoval(${img.id}); event.stopPropagation();">
                    ${isMarked ? '↺' : '×'}
                </button>
            </div>
        `;
    }).join('');
    
    document.getElementById('edit-main-image-id').value = editMainImageId || '';
}

function setEditMainImage(imageId, event) {
    if (event) event.stopPropagation();
    editMainImageId = imageId;
    
    const dish = dishes.find(d => d.id === currentEditDishId);
    if (dish) renderCurrentImages(dish);
}

function toggleImageRemoval(imageId) {
    const index = imagesToRemove.indexOf(imageId);
    if (index > -1) {
        imagesToRemove.splice(index, 1);
    } else {
        imagesToRemove.push(imageId);
    }
    
    const dish = dishes.find(d => d.id === currentEditDishId);
    if (dish) renderCurrentImages(dish);
}

function handleNewImages(input) {
    newImageFiles = Array.from(input.files);
    renderNewImagesPreview();
}

function renderNewImagesPreview() {
    const container = document.getElementById('new-images-preview');
    
    if (newImageFiles.length === 0) {
        container.innerHTML = '';
        return;
    }
    
    container.innerHTML = newImageFiles.map((file, index) => {
        const url = URL.createObjectURL(file);
        return `
            <div class="new-image-preview">
                <img src="${url}" alt="New image" />
                <button type="button" class="remove-image-btn" onclick="removeNewImage(${index})">×</button>
            </div>
        `;
    }).join('');
}

function removeNewImage(index) {
    newImageFiles.splice(index, 1);
    renderNewImagesPreview();
}

// Drag and drop support
const uploadArea = document.getElementById('image-upload-area');
if (uploadArea) {
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
        if (files.length) {
            newImageFiles = [...newImageFiles, ...files];
            renderNewImagesPreview();
        }
    });
}

function closeEditModal() {
    document.getElementById('edit-modal').classList.remove('show');
    document.body.style.overflow = '';
    currentEditDishId = null;
    imagesToRemove = [];
    newImageFiles = [];
    
    // Clear any validation errors
    document.querySelectorAll('#edit-form .form-group').forEach(g => {
        g.classList.remove('has-error', 'has-success');
    });
}

function validateEditForm() {
    const V = window.SmartValidator;
    let isValid = true;
    
    // Validate categories
    if (editCategories.length === 0) {
        const container = document.getElementById('edit-categories-container');
        const formGroup = container.closest('.form-group');
        formGroup.classList.add('has-error');
        let errorDiv = formGroup.querySelector('.form-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'form-error';
            formGroup.appendChild(errorDiv);
        }
        errorDiv.textContent = 'Please select at least one category';
        isValid = false;
    } else {
        const container = document.getElementById('edit-categories-container');
        const formGroup = container.closest('.form-group');
        formGroup.classList.remove('has-error');
        const errorDiv = formGroup.querySelector('.form-error');
        if (errorDiv) errorDiv.textContent = '';
    }
    
    // Validate dish name
    const nameInput = document.getElementById('edit-name');
    if (!nameInput.value.trim()) {
        V.setError(nameInput, 'Dish name is required');
        isValid = false;
    } else if (nameInput.value.trim().length < 2) {
        V.setError(nameInput, 'Dish name must be at least 2 characters');
        isValid = false;
    } else {
        V.setSuccess(nameInput);
    }
    
    // Validate website (optional)
    const websiteInput = document.getElementById('edit-website');
    if (websiteInput.value && !websiteInput.value.match(/^https?:\/\/.+/)) {
        V.setError(websiteInput, 'Please enter a valid URL (starting with http:// or https://)');
        isValid = false;
    } else {
        V.clearError(websiteInput);
    }
    
    // Validate phone (optional)
    const phoneInput = document.getElementById('edit-phone');
    if (phoneInput.value && !phoneInput.value.match(/^[\d\s\-\+\(\)\.]{7,}$/)) {
        V.setError(phoneInput, 'Please enter a valid phone number');
        isValid = false;
    } else {
        V.clearError(phoneInput);
    }
    
    // Validate meal cost (required)
    const mealCostInput = document.getElementById('edit-meal-cost');
    if (!mealCostInput.value) {
        V.setError(mealCostInput, 'Meal cost is required');
        isValid = false;
    } else if (parseFloat(mealCostInput.value) < 0) {
        V.setError(mealCostInput, 'Meal cost cannot be negative');
        isValid = false;
    } else {
        V.setSuccess(mealCostInput);
    }
    
    return isValid;
}

// Attach live validation to edit form fields
document.getElementById('edit-name').addEventListener('blur', function() {
    const V = window.SmartValidator;
    if (!this.value.trim()) {
        V.setError(this, 'Dish name is required');
    } else if (this.value.trim().length < 2) {
        V.setError(this, 'Dish name must be at least 2 characters');
    } else {
        V.setSuccess(this);
    }
});

document.getElementById('edit-website').addEventListener('blur', function() {
    const V = window.SmartValidator;
    if (this.value && !this.value.match(/^https?:\/\/.+/)) {
        V.setError(this, 'Please enter a valid URL (starting with http:// or https://)');
    } else {
        V.clearError(this);
    }
});

document.getElementById('edit-phone').addEventListener('blur', function() {
    const V = window.SmartValidator;
    if (this.value && !this.value.match(/^[\d\s\-\+\(\)\.]{7,}$/)) {
        V.setError(this, 'Please enter a valid phone number');
    } else {
        V.clearError(this);
    }
});

document.getElementById('edit-meal-cost').addEventListener('blur', function() {
    const V = window.SmartValidator;
    if (!this.value) {
        V.setError(this, 'Meal cost is required');
    } else if (parseFloat(this.value) < 0) {
        V.setError(this, 'Meal cost cannot be negative');
    } else {
        V.setSuccess(this);
    }
});

document.getElementById('edit-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Validate form
    if (!validateEditForm()) {
        const firstError = this.querySelector('.form-group.has-error');
        if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }
    
    const dishId = document.getElementById('edit-dish-id').value;
    const submitBtn = document.getElementById('edit-submit-btn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Saving...';
    
    // Use FormData to support file uploads
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('name', document.getElementById('edit-name').value);
    formData.append('comment', document.getElementById('edit-comment').value || '');
    formData.append('meal_cost', document.getElementById('edit-meal-cost').value || '');
    formData.append('website', document.getElementById('edit-website').value || '');
    formData.append('phone', document.getElementById('edit-phone').value || '');
    formData.append('good_date_spot', document.querySelector('input[name="edit-date-spot"]:checked').value === '1' ? '1' : '0');
    formData.append('reservation', document.querySelector('input[name="edit-reservation"]:checked').value === '1' ? '1' : '0');
    
    // Add categories
    editCategories.forEach(catId => {
        formData.append('categories[]', catId);
    });
    
    // Add main image ID if changed
    if (editMainImageId) {
        formData.append('set_main_image_id', editMainImageId);
    }
    
    // Add images to remove
    imagesToRemove.forEach(id => {
        formData.append('remove_images[]', id);
    });
    
    // Add new images
    newImageFiles.forEach(file => {
        formData.append('images[]', file);
    });
    
    try {
        const res = await fetch(`/api/dishes/${dishId}`, {
            method: 'POST', // Use POST with _method override for file uploads
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });
        
        if (!res.ok) {
            const error = await res.json();
            throw new Error(error.error || 'Failed to update dish');
        }
        
        closeEditModal();
        loadDishes(); // Reload dishes
        
    } catch (e) {
        alert('Error: ' + e.message);
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});

async function deleteDish(dishId) {
    if (!confirm('Are you sure you want to delete this dish? This cannot be undone.')) return;
    
    try {
        const res = await fetch(`/api/dishes/${dishId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (!res.ok) {
            const error = await res.json();
            throw new Error(error.error || 'Failed to delete dish');
        }
        
        loadDishes(); // Reload dishes
        
    } catch (e) {
        alert('Error: ' + e.message);
    }
}

// Close modal on backdrop click
document.getElementById('edit-modal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeEditModal();
});

// Load dishes on page load
loadDishes();
</script>
@endpush
