@extends('admin.layout')

@section('title', $restaurant->exists ? 'Edit Restaurant' : 'New Restaurant')

@section('content')
    <div class="breadcrumb">
        <a href="/admin">Dashboard</a>
        <span>›</span>
        <a href="/admin/restaurants">Restaurants</a>
        <span>›</span>
        <span>{{ $restaurant->exists ? 'Edit' : 'New' }}</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $restaurant->exists ? 'Edit Restaurant' : 'Create New Restaurant' }}</h1>
            <p class="page-subtitle">{{ $restaurant->exists ? 'Update restaurant details' : 'Add a new restaurant to the platform' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="restaurant-form">
                <input type="hidden" name="id" value="{{ $restaurant->id ?? '' }}" />
                
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #475569;">Basic Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" value="{{ $restaurant->name ?? '' }}" class="form-control" placeholder="Restaurant name" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Website</label>
                        <input type="url" name="website" value="{{ $restaurant->website ?? '' }}" class="form-control" placeholder="https://example.com" />
                    </div>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569;">Location</h3>
                
                <div class="form-group">
                    <label class="form-label">Address <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="address" value="{{ $restaurant->address ?? '' }}" class="form-control" placeholder="Street address" required />
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">City <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="city" value="{{ $restaurant->city ?? '' }}" class="form-control" placeholder="City" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Region / State <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="region" value="{{ $restaurant->region ?? '' }}" class="form-control" placeholder="Region or state" required />
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Country <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="country" value="{{ $restaurant->country ?? '' }}" class="form-control" placeholder="Country" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Postcode <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="postcode" value="{{ $restaurant->postcode ?? '' }}" class="form-control" placeholder="ZIP / Postcode" required />
                    </div>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569;">Additional Details</h3>
                
                <div class="form-group">
                    <label class="form-label">Opening Hours</label>
                    <textarea name="opening_hours" class="form-control" rows="3" placeholder="e.g., Mon-Fri: 9am-10pm, Sat-Sun: 10am-11pm">{{ $restaurant->opening_hours ?? '' }}</textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Meal Cost ($)</label>
                        <input type="number" step="0.01" min="0" name="meal_cost" value="{{ $restaurant->meal_cost ?? '' }}" class="form-control" placeholder="e.g., 25.00" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Good Date Spot?</label>
                        <div style="display: flex; gap: 1.5rem; padding: 0.75rem 0;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="radio" name="good_date_spot" value="1" {{ isset($restaurant) && $restaurant->good_date_spot ? 'checked' : '' }} style="accent-color: var(--primary);">
                                <span>Yes</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="radio" name="good_date_spot" value="0" {{ !isset($restaurant) || !$restaurant->good_date_spot ? 'checked' : '' }} style="accent-color: var(--primary);">
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" value="{{ $restaurant->phone ?? '' }}" class="form-control" placeholder="e.g., +1 (555) 123-4567" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Accepts Reservations?</label>
                        <div style="display: flex; gap: 1.5rem; padding: 0.75rem 0;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="radio" name="reservation" value="1" {{ isset($restaurant) && $restaurant->reservation ? 'checked' : '' }} style="accent-color: var(--primary);">
                                <span>Yes</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="radio" name="reservation" value="0" {{ !isset($restaurant) || !$restaurant->reservation ? 'checked' : '' }} style="accent-color: var(--primary);">
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Categories</label>
                    <div id="categories-checkboxes" style="display: flex; flex-wrap: wrap; gap: 0.75rem; padding: 0.5rem 0;">
                        <span class="text-muted">Loading categories...</span>
                    </div>
                </div>
                
                @if($restaurant->exists)
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">Status</h3>
                
                <div class="form-group">
                    <label class="form-label">Approval Status</label>
                    <div style="display: flex; gap: 1.5rem; padding: 0.75rem 0;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="is_approved" value="1" {{ $restaurant->is_approved ? 'checked' : '' }} style="accent-color: var(--primary);">
                            <span><span class="badge badge-success">Approved</span></span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="is_approved" value="0" {{ !$restaurant->is_approved ? 'checked' : '' }} style="accent-color: var(--primary);">
                            <span><span class="badge badge-warning">Pending</span></span>
                        </label>
                    </div>
                </div>
                @endif
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon"><use href="#icon-save"></use></svg> {{ $restaurant->exists ? 'Update Restaurant' : 'Create Restaurant' }}
                    </button>
                    <a href="/admin/restaurants" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const form = document.getElementById('restaurant-form');
const existingCategoryIds = @json($restaurant->categories->pluck('id') ?? []);

async function loadCategories() {
    try {
        const categories = await adminFetch('GET', '/admin/api/categories');
        const container = document.getElementById('categories-checkboxes');
        
        if (!categories || !categories.length) {
            container.innerHTML = '<span class="text-muted">No categories available. <a href="/admin/categories/create" style="color: var(--primary);">Create one</a></span>';
            return;
        }
        
        container.innerHTML = categories.map(c => `
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="category_ids" value="${c.id}" ${existingCategoryIds.includes(c.id) ? 'checked' : ''} style="accent-color: var(--primary);">
                <span>${c.name}</span>
            </label>
        `).join('');
    } catch (e) {
        document.getElementById('categories-checkboxes').innerHTML = '<span style="color: #ef4444;">Failed to load categories</span>';
    }
}

form.addEventListener('submit', async e => {
    e.preventDefault();
    
    const id = form.id.value;
    const categoryCheckboxes = form.querySelectorAll('input[name="category_ids"]:checked');
    const categoryIds = Array.from(categoryCheckboxes).map(cb => parseInt(cb.value));
    
    const mealCostValue = form.meal_cost.value.trim();
    const goodDateSpotRadio = form.querySelector('input[name="good_date_spot"]:checked');
    const reservationRadio = form.querySelector('input[name="reservation"]:checked');
    
    const payload = {
        name: form.name.value.trim(),
        address: form.address.value.trim(),
        city: form.city.value.trim(),
        region: form.region.value.trim(),
        country: form.country.value.trim(),
        postcode: form.postcode.value.trim(),
        website: form.website.value.trim() || null,
        opening_hours: form.opening_hours.value.trim() || null,
        meal_cost: mealCostValue ? parseFloat(mealCostValue) : null,
        good_date_spot: goodDateSpotRadio ? goodDateSpotRadio.value === '1' : false,
        phone: form.phone.value.trim() || null,
        reservation: reservationRadio ? reservationRadio.value === '1' : false,
        category_ids: categoryIds
    };
    
    // Add is_approved for existing restaurants
    const isApprovedRadio = form.querySelector('input[name="is_approved"]:checked');
    if (isApprovedRadio) {
        payload.is_approved = isApprovedRadio.value === '1';
    }
    
    // Validate required fields
    const required = ['name', 'address', 'city', 'region', 'country', 'postcode'];
    for (const field of required) {
        if (!payload[field]) {
            alert(`${field.charAt(0).toUpperCase() + field.slice(1).replace('_', ' ')} is required`);
            return;
        }
    }
    
    try {
        if (id) {
            await adminFetch('PUT', '/admin/api/restaurants/' + id, payload);
        } else {
            await adminFetch('POST', '/admin/api/restaurants', payload);
        }
        location.href = '/admin/restaurants';
    } catch (err) {
        alert('Save failed: ' + err.message);
    }
});

loadCategories();
</script>
@endpush
