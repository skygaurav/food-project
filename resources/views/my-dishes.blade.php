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
            <form id="edit-form">
                <div class="modal-body">
                    <input type="hidden" id="edit-dish-id" />
                    
                    <div class="form-group">
                        <label class="form-label">Dish Name</label>
                        <input type="text" id="edit-name" class="form-control" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Comment</label>
                        <textarea id="edit-comment" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Meal Cost ($)</label>
                        <input type="number" id="edit-meal-cost" class="form-control" step="0.01" min="0" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Website</label>
                        <input type="url" id="edit-website" class="form-control" placeholder="https://" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" id="edit-phone" class="form-control" />
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
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
let dishes = [];

async function loadDishes() {
    try {
        const res = await fetch('/api/my-dishes', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (!res.ok) throw new Error('Failed to load dishes');
        
        dishes = await res.json();
        renderDishes();
        
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

function openEditModal(dishId) {
    const dish = dishes.find(d => d.id === dishId);
    if (!dish) return;
    
    document.getElementById('edit-dish-id').value = dish.id;
    document.getElementById('edit-name').value = dish.name || '';
    document.getElementById('edit-comment').value = dish.comment || '';
    document.getElementById('edit-meal-cost').value = dish.meal_cost || '';
    document.getElementById('edit-website').value = dish.website || '';
    document.getElementById('edit-phone').value = dish.phone || '';
    
    document.querySelector(`input[name="edit-date-spot"][value="${dish.good_date_spot ? '1' : '0'}"]`).checked = true;
    document.querySelector(`input[name="edit-reservation"][value="${dish.reservation ? '1' : '0'}"]`).checked = true;
    
    document.getElementById('edit-modal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('edit-modal').classList.remove('show');
    document.body.style.overflow = '';
}

document.getElementById('edit-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const dishId = document.getElementById('edit-dish-id').value;
    const data = {
        name: document.getElementById('edit-name').value,
        comment: document.getElementById('edit-comment').value || null,
        meal_cost: document.getElementById('edit-meal-cost').value || null,
        website: document.getElementById('edit-website').value || null,
        phone: document.getElementById('edit-phone').value || null,
        good_date_spot: document.querySelector('input[name="edit-date-spot"]:checked').value === '1',
        reservation: document.querySelector('input[name="edit-reservation"]:checked').value === '1',
    };
    
    try {
        const res = await fetch(`/api/dishes/${dishId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        if (!res.ok) {
            const error = await res.json();
            throw new Error(error.error || 'Failed to update dish');
        }
        
        closeEditModal();
        loadDishes(); // Reload dishes
        
    } catch (e) {
        alert('Error: ' + e.message);
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
