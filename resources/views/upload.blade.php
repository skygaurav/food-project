@extends('layouts.frontend')

@section('title', 'Upload Dish')

@push('styles')
<style>
    .upload-container {
        max-width: 700px;
        margin: 0 auto;
    }
    
    .upload-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .upload-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 0.5rem 0;
    }
    
    .upload-subtitle {
        color: var(--text-muted);
        margin: 0;
    }
    
    .upload-form {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-section:last-child {
        margin-bottom: 0;
    }
    
    .form-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    
    .form-label .required {
        color: #ef4444;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        color: var(--text-dark);
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(232, 93, 4, 0.1);
    }
    
    .form-control::placeholder {
        color: #94a3b8;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    
    .file-upload {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }
    
    .file-upload:hover {
        border-color: var(--primary);
        background: #fff5eb;
    }
    
    .file-upload-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }
    
    .file-upload-text {
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    
    .file-upload input {
        display: none;
    }
    
    .image-previews {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .image-preview {
        position: relative;
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        border: 3px solid transparent;
        transition: border-color 0.2s;
    }
    
    .image-preview.is-main {
        border-color: var(--primary);
    }
    
    .image-preview::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0);
        transition: background 0.2s;
    }
    
    .image-preview:hover::before {
        background: rgba(0,0,0,0.2);
    }
    
    .image-preview .main-badge {
        position: absolute;
        bottom: 4px;
        left: 4px;
        background: var(--primary);
        color: #fff;
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .image-preview-remove {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 20px;
        height: 20px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        border: none;
        border-radius: 50%;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .radio-group {
        display: flex;
        gap: 1.5rem;
    }
    
    .radio-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .radio-option input {
        accent-color: var(--primary);
    }
    
    .submit-btn {
        width: 100%;
        padding: 1rem;
        font-size: 1rem;
        font-weight: 600;
    }
    
    .success-message {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 1px solid #10b981;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .success-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .success-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: #065f46;
        margin: 0 0 0.5rem 0;
    }
    
    .success-text {
        color: #047857;
        margin: 0;
    }
    
    /* Autocomplete styles */
    .autocomplete-wrapper {
        position: relative;
    }
    
    .autocomplete-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-top: none;
        border-radius: 0 0 8px 8px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 100;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        display: none;
    }
    
    .autocomplete-results.show {
        display: block;
    }
    
    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    
    .autocomplete-item:last-child {
        border-bottom: none;
    }
    
    .autocomplete-item:hover,
    .autocomplete-item.active {
        background: #fff7ed;
    }
    
    .autocomplete-item-name {
        font-weight: 500;
        color: var(--text-dark);
    }
    
    .autocomplete-item-location {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    
    .autocomplete-new {
        padding: 0.75rem 1rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        color: var(--primary);
        font-weight: 500;
        cursor: pointer;
    }
    
    .autocomplete-new:hover {
        background: #fff7ed;
    }
    
    /* Categories multiselect */
    .categories-select {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .category-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
    }
    
    .category-chip:hover {
        border-color: var(--primary);
        background: #fff7ed;
    }
    
    .category-chip.selected {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }
    
    .category-chip input {
        display: none;
    }
    
    .new-restaurant-fields {
        display: none;
        margin-top: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    
    .new-restaurant-fields.show {
        display: block;
    }
    
    .new-restaurant-fields .form-row {
        margin-bottom: 0;
    }
    
    .selected-restaurant {
        display: none;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #d1fae5;
        border: 1px solid #10b981;
        border-radius: 8px;
        margin-top: 0.5rem;
    }
    
    .selected-restaurant.show {
        display: flex;
    }
    
    .selected-restaurant-name {
        flex: 1;
        font-weight: 500;
        color: #065f46;
    }
    
    .selected-restaurant-clear {
        background: none;
        border: none;
        color: #065f46;
        cursor: pointer;
        font-size: 1.25rem;
        padding: 0;
        line-height: 1;
    }
</style>
@endpush

@section('content')
    <div class="upload-container">
        <div class="upload-header">
            <h1 class="upload-title"><svg class="icon icon-lg icon-primary"><use href="#icon-camera"></use></svg> Upload a Dish</h1>
            <p class="upload-subtitle">Share your favorite dish with the FOODCITA community</p>
        </div>

        <div id="success-message" class="success-message" style="display: none;">
            <div class="success-icon"><svg class="icon icon-4xl icon-success"><use href="#icon-check"></use></svg></div>
            <h2 class="success-title">Dish Submitted Successfully!</h2>
            <p class="success-text">Your dish has been submitted and is pending admin approval.</p>
            <a href="/" class="btn btn-primary" style="margin-top: 1rem;">Back to Home</a>
        </div>

        <form id="upload-form" class="upload-form" enctype="multipart/form-data" novalidate>
            <div class="form-section">
                <h3 class="form-section-title"><svg class="icon"><use href="#icon-location"></use></svg> Restaurant Details</h3>
                
                <div class="form-group">
                    <label class="form-label">Restaurant Name <span class="required">*</span></label>
                    <div class="autocomplete-wrapper">
                        <input type="text" id="restaurant_search" class="form-control" 
                               placeholder="Start typing restaurant name..." autocomplete="off" />
                        <input type="hidden" id="restaurant_id" name="restaurant_id" />
                        <input type="hidden" id="restaurant_name" name="restaurant_name" />
                        <div id="autocomplete-results" class="autocomplete-results"></div>
                    </div>
                    <div class="form-error"></div>
                    
                    <div id="selected-restaurant" class="selected-restaurant">
                        <span class="selected-restaurant-name" id="selected-restaurant-name"></span>
                        <button type="button" class="selected-restaurant-clear" id="clear-restaurant">&times;</button>
                    </div>
                </div>
                
                <div id="new-restaurant-fields" class="new-restaurant-fields">
                    <p style="margin: 0 0 1rem 0; font-size: 0.875rem; color: var(--text-muted);">
                        <svg class="icon icon-sm"><use href="#icon-edit"></use></svg> Restaurant not found? Enter the address details below:
                    </p>
                    <div class="form-group">
                        <label class="form-label">Street Address</label>
                        <input type="text" id="restaurant_address" name="restaurant_address" class="form-control" 
                               placeholder="e.g. 123 Main Street" />
                        <div class="form-error"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">City <span class="required">*</span></label>
                            <input type="text" id="restaurant_city" name="restaurant_city" class="form-control" 
                                   placeholder="e.g. Los Angeles" />
                            <div class="form-error"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">State <span class="required">*</span></label>
                            <input type="text" id="restaurant_state" name="restaurant_state" class="form-control" 
                                   placeholder="e.g. California" />
                            <div class="form-error"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Postcode <span class="required">*</span></label>
                            <input type="text" id="restaurant_postcode" name="restaurant_postcode" class="form-control" 
                                   placeholder="e.g. 90001" />
                            <div class="form-error"></div>
                        </div>
                        <div class="form-group"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Restaurant Categories <span class="required">*</span></label>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.75rem;">Select one or more categories that best describe this restaurant</p>
                    <div id="categories-container" class="categories-select">
                        <!-- Categories will be loaded here -->
                        <span style="color: var(--text-muted); font-size: 0.875rem;">Loading categories...</span>
                    </div>
                    <div class="form-error"></div>
                </div>
            </div>
            
            <div class="form-section">
                <h3 class="form-section-title"><svg class="icon"><use href="#icon-dish"></use></svg> Dish Information</h3>
                
                <div class="form-group">
                    <label class="form-label">Dish Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Spicy Tuna Roll, Margherita Pizza" />
                    <div class="form-error"></div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Your Comment / Review</label>
                    <textarea id="comment" name="comment" class="form-control" placeholder="What did you love about this dish? Any recommendations?"></textarea>
                    <div class="form-error"></div>
                </div>
                
                <div class="form-group" id="images-group">
                    <label class="form-label">Photos <span class="required">*</span></label>
                    <div class="file-upload" onclick="document.getElementById('images').click()">
                        <div class="file-upload-icon"><svg class="icon icon-3xl icon-muted"><use href="#icon-image"></use></svg></div>
                        <div class="file-upload-text">Click to upload photos or drag & drop</div>
                        <div class="file-upload-text" style="font-size: 0.8rem; margin-top: 0.25rem;">PNG, JPG up to 5MB each</div>
                        <input type="file" id="images" name="images[]" accept="image/*" multiple />
                    </div>
                    <div class="form-error"></div>
                    <p id="main-image-hint" style="display: none; font-size: 0.8rem; color: var(--text-muted); margin-top: 0.5rem;">
                        <svg class="icon icon-sm"><use href="#icon-info"></use></svg> Click on an image to set it as the main image
                    </p>
                    <div id="image-previews" class="image-previews"></div>
                    <input type="hidden" id="main_image_index" name="main_image_index" value="0" />
                </div>
            </div>
            
            <div class="form-section">
                <h3 class="form-section-title"><svg class="icon"><use href="#icon-info"></use></svg> Additional Details</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Meal Cost ($) <span class="required">*</span></label>
                        <input type="number" id="meal_cost" name="meal_cost" class="form-control" step="0.01" min="0" placeholder="e.g. 25.00" />
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Restaurant Website</label>
                        <input type="url" id="website" name="website" class="form-control" placeholder="https://..." />
                        <div class="form-error"></div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Restaurant Phone</label>
                        <input type="tel" id="phone" name="phone" class="form-control" placeholder="e.g. (555) 123-4567" />
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Takes Reservations?</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="reservation" value="1" />
                                <span>Yes</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="reservation" value="0" checked />
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Good Date Spot?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="good_date_spot" value="1" />
                            <span>Yes <svg class="icon icon-sm icon-danger icon-filled"><use href="#icon-heart-filled"></use></svg></span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="good_date_spot" value="0" checked />
                            <span>No</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <button type="submit" id="submit-btn" class="btn btn-primary submit-btn">
                <svg class="icon"><use href="#icon-rocket"></use></svg> Submit Dish
            </button>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('upload-form');
    const submitBtn = document.getElementById('submit-btn');
    const successMessage = document.getElementById('success-message');
    const imagesInput = document.getElementById('images');
    const imagePreviews = document.getElementById('image-previews');
    const mainImageHint = document.getElementById('main-image-hint');
    const mainImageIndexInput = document.getElementById('main_image_index');
    
    // Restaurant autocomplete elements
    const restaurantSearch = document.getElementById('restaurant_search');
    const restaurantIdInput = document.getElementById('restaurant_id');
    const restaurantNameInput = document.getElementById('restaurant_name');
    const autocompleteResults = document.getElementById('autocomplete-results');
    const selectedRestaurant = document.getElementById('selected-restaurant');
    const selectedRestaurantName = document.getElementById('selected-restaurant-name');
    const clearRestaurantBtn = document.getElementById('clear-restaurant');
    const newRestaurantFields = document.getElementById('new-restaurant-fields');
    
    let searchTimeout = null;
    let isNewRestaurant = false;
    let mainImageIndex = 0;
    let selectedCategories = [];
    
    // Load categories
    async function loadCategories() {
        try {
            const res = await fetch('/api/categories');
            const categories = await res.json();
            
            const container = document.getElementById('categories-container');
            container.innerHTML = categories.map(cat => `
                <label class="category-chip" data-id="${cat.id}">
                    <input type="checkbox" name="categories[]" value="${cat.id}" />
                    ${cat.name}
                </label>
            `).join('');
            
            // Add click handlers
            container.querySelectorAll('.category-chip').forEach(chip => {
                chip.addEventListener('click', function(e) {
                    if (e.target.tagName === 'INPUT') return;
                    const checkbox = this.querySelector('input');
                    checkbox.checked = !checkbox.checked;
                    this.classList.toggle('selected', checkbox.checked);
                });
                
                chip.querySelector('input').addEventListener('change', function() {
                    chip.classList.toggle('selected', this.checked);
                });
            });
        } catch (e) {
            console.error('Failed to load categories:', e);
            document.getElementById('categories-container').innerHTML = 
                '<span style="color: #dc2626; font-size: 0.875rem;">Failed to load categories</span>';
        }
    }
    
    loadCategories();
    
    // Autocomplete search
    restaurantSearch.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Clear previous timeout
        if (searchTimeout) clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            autocompleteResults.classList.remove('show');
            return;
        }
        
        // Debounce search
        searchTimeout = setTimeout(async () => {
            try {
                const res = await fetch(`/api/restaurants/search?q=${encodeURIComponent(query)}`);
                const restaurants = await res.json();
                
                let html = '';
                
                if (restaurants.length) {
                    html = restaurants.map(r => `
                        <div class="autocomplete-item" data-id="${r.id}" data-name="${r.name}" data-city="${r.city || ''}">
                            <div class="autocomplete-item-name">${r.name}</div>
                            <div class="autocomplete-item-location">${r.city || ''}${r.postcode ? ', ' + r.postcode : ''}</div>
                        </div>
                    `).join('');
                }
                
                // Always show "Add new restaurant" option
                html += `
                    <div class="autocomplete-new" data-new="true">
                        <span><svg class="icon icon-sm"><use href="#icon-plus"></use></svg> Add "${query}" as new restaurant</span>
                    </div>
                `;
                
                autocompleteResults.innerHTML = html;
                autocompleteResults.classList.add('show');
                
                // Attach click handlers
                autocompleteResults.querySelectorAll('.autocomplete-item').forEach(item => {
                    item.addEventListener('click', () => selectRestaurant(item));
                });
                
                autocompleteResults.querySelector('.autocomplete-new').addEventListener('click', () => {
                    selectNewRestaurant(query);
                });
                
            } catch (e) {
                console.error('Search failed:', e);
            }
        }, 300);
    });
    
    // Select existing restaurant
    function selectRestaurant(item) {
        const id = item.dataset.id;
        const name = item.dataset.name;
        const city = item.dataset.city;
        
        restaurantIdInput.value = id;
        restaurantNameInput.value = '';
        isNewRestaurant = false;
        
        selectedRestaurantName.textContent = name + (city ? ` (${city})` : '');
        selectedRestaurant.classList.add('show');
        restaurantSearch.style.display = 'none';
        autocompleteResults.classList.remove('show');
        newRestaurantFields.classList.remove('show');
    }
    
    // Select new restaurant
    function selectNewRestaurant(name) {
        restaurantIdInput.value = '';
        restaurantNameInput.value = name;
        isNewRestaurant = true;
        
        selectedRestaurantName.textContent = `${name} (New)`;
        selectedRestaurant.classList.add('show');
        restaurantSearch.style.display = 'none';
        autocompleteResults.classList.remove('show');
        newRestaurantFields.classList.add('show');
    }
    
    // Clear restaurant selection
    clearRestaurantBtn.addEventListener('click', function() {
        restaurantIdInput.value = '';
        restaurantNameInput.value = '';
        isNewRestaurant = false;
        
        selectedRestaurant.classList.remove('show');
        restaurantSearch.style.display = 'block';
        restaurantSearch.value = '';
        newRestaurantFields.classList.remove('show');
        
        // Clear new restaurant fields
        document.getElementById('restaurant_address').value = '';
        document.getElementById('restaurant_city').value = '';
        document.getElementById('restaurant_state').value = '';
        document.getElementById('restaurant_postcode').value = '';
    });
    
    // Close autocomplete on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.autocomplete-wrapper')) {
            autocompleteResults.classList.remove('show');
        }
    });
    
    // Image preview with main image selection
    imagesInput.addEventListener('change', function() {
        imagePreviews.innerHTML = '';
        mainImageIndex = 0;
        mainImageIndexInput.value = '0';
        
        if (this.files.length > 0) {
            mainImageHint.style.display = 'block';
        } else {
            mainImageHint.style.display = 'none';
        }
        
        Array.from(this.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'image-preview' + (index === 0 ? ' is-main' : '');
                preview.dataset.index = index;
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" />
                    ${index === 0 ? '<span class="main-badge">Main</span>' : ''}
                `;
                preview.addEventListener('click', function() {
                    setMainImage(parseInt(this.dataset.index));
                });
                imagePreviews.appendChild(preview);
            };
            reader.readAsDataURL(file);
        });
    });
    
    function setMainImage(index) {
        mainImageIndex = index;
        mainImageIndexInput.value = index.toString();
        
        document.querySelectorAll('.image-preview').forEach((p, i) => {
            p.classList.toggle('is-main', i === index);
            const badge = p.querySelector('.main-badge');
            if (i === index) {
                if (!badge) {
                    const span = document.createElement('span');
                    span.className = 'main-badge';
                    span.textContent = 'Main';
                    p.appendChild(span);
                }
            } else {
                if (badge) badge.remove();
            }
        });
    }
    
    // Form submit
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const V = window.SmartValidator;
        let isValid = true;
        
        // Validate restaurant selection
        const restaurantGroup = document.querySelector('#restaurant_search').closest('.form-group');
        if (!restaurantIdInput.value && !restaurantNameInput.value) {
            V.setError(restaurantSearch, 'Please select or enter a restaurant name');
            isValid = false;
        } else {
            V.clearError(restaurantSearch);
        }
        
        // Validate new restaurant fields
        if (isNewRestaurant) {
            const cityInput = document.getElementById('restaurant_city');
            const stateInput = document.getElementById('restaurant_state');
            const postcodeInput = document.getElementById('restaurant_postcode');
            
            if (!cityInput.value.trim()) {
                V.setError(cityInput, 'City is required for new restaurants');
                isValid = false;
            } else {
                V.clearError(cityInput);
            }
            
            if (!stateInput.value.trim()) {
                V.setError(stateInput, 'State is required for new restaurants');
                isValid = false;
            } else {
                V.clearError(stateInput);
            }
            
            if (!postcodeInput.value.trim()) {
                V.setError(postcodeInput, 'Postcode is required for new restaurants');
                isValid = false;
            } else {
                V.clearError(postcodeInput);
            }
        }
        
        // Validate categories
        const categoriesContainer = document.getElementById('categories-container');
        const selectedCats = categoriesContainer.querySelectorAll('input[name="categories[]"]:checked');
        if (selectedCats.length === 0) {
            const catGroup = categoriesContainer.closest('.form-group');
            catGroup.classList.add('has-error');
            let errorEl = catGroup.querySelector('.form-error');
            if (errorEl) errorEl.innerHTML = '<svg class="icon icon-xs"><use href="#icon-x"></use></svg> Please select at least one category';
            isValid = false;
        } else {
            const catGroup = categoriesContainer.closest('.form-group');
            catGroup.classList.remove('has-error');
            let errorEl = catGroup.querySelector('.form-error');
            if (errorEl) errorEl.style.display = 'none';
        }
        
        // Validate dish name
        const nameInput = document.getElementById('name');
        if (!nameInput.value.trim()) {
            V.setError(nameInput, 'Dish name is required');
            isValid = false;
        } else if (nameInput.value.trim().length < 2) {
            V.setError(nameInput, 'Dish name must be at least 2 characters');
            isValid = false;
        } else {
            V.setSuccess(nameInput);
        }
        
        // Validate images
        const imagesGroup = document.getElementById('images-group');
        if (!imagesInput.files || imagesInput.files.length === 0) {
            V.setError(imagesInput, 'Please upload at least one photo');
            isValid = false;
        } else {
            V.clearError(imagesInput);
        }
        
        // Validate optional URL fields
        const websiteInput = document.getElementById('website');
        if (websiteInput.value && !websiteInput.value.match(/^https?:\/\/.+/)) {
            V.setError(websiteInput, 'Please enter a valid URL (starting with http:// or https://)');
            isValid = false;
        } else {
            V.clearError(websiteInput);
        }
        
        // Validate optional phone
        const phoneInput = document.getElementById('phone');
        if (phoneInput.value && !phoneInput.value.match(/^[\d\s\-\+\(\)\.]{7,}$/)) {
            V.setError(phoneInput, 'Please enter a valid phone number');
            isValid = false;
        } else {
            V.clearError(phoneInput);
        }
        
        // Validate meal cost (now required)
        const mealCostInput = document.getElementById('meal_cost');
        if (!mealCostInput.value || mealCostInput.value.trim() === '') {
            V.setError(mealCostInput, 'Meal cost is required');
            isValid = false;
        } else if (parseFloat(mealCostInput.value) < 0) {
            V.setError(mealCostInput, 'Meal cost cannot be negative');
            isValid = false;
        } else {
            V.setSuccess(mealCostInput);
        }
        
        if (!isValid) {
            const firstError = form.querySelector('.form-group.has-error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="icon icon-spin"><use href="#icon-loader"></use></svg> Uploading...';
        
        const formData = new FormData(form);
        
        try {
            const res = await fetch('/api/dishes', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            if (!res.ok) {
                const error = await res.json();
                throw new Error(error.message || 'Failed to upload dish');
            }
            
            form.style.display = 'none';
            successMessage.style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
        } catch (err) {
            alert('Error: ' + err.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<svg class="icon"><use href="#icon-rocket"></use></svg> Submit Dish';
        }
    });
    
    // Live validation for key fields
    const V = window.SmartValidator;
    
    document.getElementById('name').addEventListener('blur', function() {
        if (!this.value.trim()) {
            V.setError(this, 'Dish name is required');
        } else if (this.value.trim().length < 2) {
            V.setError(this, 'Dish name must be at least 2 characters');
        } else {
            V.setSuccess(this);
        }
    });
    
    document.getElementById('website').addEventListener('blur', function() {
        if (this.value && !this.value.match(/^https?:\/\/.+/)) {
            V.setError(this, 'Please enter a valid URL (starting with http:// or https://)');
        } else {
            V.clearError(this);
        }
    });
    
    document.getElementById('phone').addEventListener('blur', function() {
        if (this.value && !this.value.match(/^[\d\s\-\+\(\)\.]{7,}$/)) {
            V.setError(this, 'Please enter a valid phone number');
        } else {
            V.clearError(this);
        }
    });
    
    document.getElementById('meal_cost').addEventListener('blur', function() {
        if (!this.value || this.value.trim() === '') {
            V.setError(this, 'Meal cost is required');
        } else if (parseFloat(this.value) < 0) {
            V.setError(this, 'Meal cost cannot be negative');
        } else {
            V.setSuccess(this);
        }
    });
    
    imagesInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            V.clearError(this);
        }
    });
});
</script>
@endpush
