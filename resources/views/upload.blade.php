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
</style>
@endpush

@section('content')
    <div class="upload-container">
        <div class="upload-header">
            <h1 class="upload-title">📷 Upload a Dish</h1>
            <p class="upload-subtitle">Share your favorite dish with the FOODCITA community</p>
        </div>

        <div id="success-message" class="success-message" style="display: none;">
            <div class="success-icon">🎉</div>
            <h2 class="success-title">Dish Submitted Successfully!</h2>
            <p class="success-text">Your dish has been submitted and is pending admin approval.</p>
            <a href="/" class="btn btn-primary" style="margin-top: 1rem;">Back to Home</a>
        </div>

        <form id="upload-form" class="upload-form" enctype="multipart/form-data">
            <div class="form-section">
                <h3 class="form-section-title">📍 Restaurant Details</h3>
                
                <div class="form-group">
                    <label class="form-label">Select Restaurant <span class="required">*</span></label>
                    <select id="restaurant_id" name="restaurant_id" class="form-control" required>
                        <option value="">Loading restaurants...</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h3 class="form-section-title">🍽️ Dish Information</h3>
                
                <div class="form-group">
                    <label class="form-label">Dish Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Spicy Tuna Roll, Margherita Pizza" required />
                </div>
                
                <div class="form-group">
                    <label class="form-label">Your Comment / Review</label>
                    <textarea id="comment" name="comment" class="form-control" placeholder="What did you love about this dish? Any recommendations?"></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Photos <span class="required">*</span></label>
                    <div class="file-upload" onclick="document.getElementById('images').click()">
                        <div class="file-upload-icon">📸</div>
                        <div class="file-upload-text">Click to upload photos or drag & drop</div>
                        <div class="file-upload-text" style="font-size: 0.8rem; margin-top: 0.25rem;">PNG, JPG up to 5MB each</div>
                        <input type="file" id="images" name="images[]" accept="image/*" multiple required />
                    </div>
                    <div id="image-previews" class="image-previews"></div>
                </div>
            </div>
            
            <div class="form-section">
                <h3 class="form-section-title">ℹ️ Additional Details</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Meal Cost ($)</label>
                        <input type="number" id="meal_cost" name="meal_cost" class="form-control" step="0.01" min="0" placeholder="e.g. 25.00" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Restaurant Website</label>
                        <input type="url" id="website" name="website" class="form-control" placeholder="https://..." />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Good Date Spot?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="good_date_spot" value="1" />
                            <span>Yes ❤️</span>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="good_date_spot" value="0" checked />
                            <span>No</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <button type="submit" id="submit-btn" class="btn btn-primary submit-btn">
                <span>🚀</span> Submit Dish
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
    const restaurantSelect = document.getElementById('restaurant_id');
    const imagesInput = document.getElementById('images');
    const imagePreviews = document.getElementById('image-previews');
    
    // Load restaurants
    async function loadRestaurants() {
        try {
            const res = await fetch('/api/restaurants');
            const restaurants = await res.json();
            
            restaurantSelect.innerHTML = '<option value="">-- Select a restaurant --</option>';
            restaurants.forEach(r => {
                const option = document.createElement('option');
                option.value = r.id;
                option.textContent = r.name + (r.city ? ` (${r.city})` : '');
                restaurantSelect.appendChild(option);
            });
        } catch (e) {
            console.error('Failed to load restaurants:', e);
            restaurantSelect.innerHTML = '<option value="">Failed to load restaurants</option>';
        }
    }
    
    // Image preview
    imagesInput.addEventListener('change', function() {
        imagePreviews.innerHTML = '';
        
        Array.from(this.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'image-preview';
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" />
                `;
                imagePreviews.appendChild(preview);
            };
            reader.readAsDataURL(file);
        });
    });
    
    // Form submit
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>⏳</span> Uploading...';
        
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
            submitBtn.innerHTML = '<span>🚀</span> Submit Dish';
        }
    });
    
    // Initial load
    loadRestaurants();
});
</script>
@endpush
