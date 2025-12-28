<?php $__env->startSection('title', isset($restaurant) ? 'Edit Restaurant' : 'New Restaurant'); ?>

<?php $__env->startSection('content'); ?>
    <div class="breadcrumb">
        <a href="/admin">Dashboard</a>
        <span>›</span>
        <a href="/admin/restaurants">Restaurants</a>
        <span>›</span>
        <span><?php echo e(isset($restaurant) ? 'Edit' : 'New'); ?></span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title"><?php echo e(isset($restaurant) ? 'Edit Restaurant' : 'Create New Restaurant'); ?></h1>
            <p class="page-subtitle"><?php echo e(isset($restaurant) ? 'Update restaurant details' : 'Add a new restaurant to the platform'); ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="restaurant-form">
                <input type="hidden" name="id" value="<?php echo e($restaurant->id ?? ''); ?>" />
                
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #475569;">Basic Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" value="<?php echo e($restaurant->name ?? ''); ?>" class="form-control" placeholder="Restaurant name" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Website</label>
                        <input type="url" name="website" value="<?php echo e($restaurant->website ?? ''); ?>" class="form-control" placeholder="https://example.com" />
                    </div>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569;">Location</h3>
                
                <div class="form-group">
                    <label class="form-label">Address <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="address" value="<?php echo e($restaurant->address ?? ''); ?>" class="form-control" placeholder="Street address" required />
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">City <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="city" value="<?php echo e($restaurant->city ?? ''); ?>" class="form-control" placeholder="City" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Region / State <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="region" value="<?php echo e($restaurant->region ?? ''); ?>" class="form-control" placeholder="Region or state" required />
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Country <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="country" value="<?php echo e($restaurant->country ?? ''); ?>" class="form-control" placeholder="Country" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Postcode <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="postcode" value="<?php echo e($restaurant->postcode ?? ''); ?>" class="form-control" placeholder="ZIP / Postcode" required />
                    </div>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569;">Additional Details</h3>
                
                <div class="form-group">
                    <label class="form-label">Opening Hours</label>
                    <textarea name="opening_hours" class="form-control" rows="3" placeholder="e.g., Mon-Fri: 9am-10pm, Sat-Sun: 10am-11pm"><?php echo e($restaurant->opening_hours ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Categories</label>
                    <div id="categories-checkboxes" style="display: flex; flex-wrap: wrap; gap: 0.75rem; padding: 0.5rem 0;">
                        <span class="text-muted">Loading categories...</span>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <span>💾</span> <?php echo e(isset($restaurant) ? 'Update Restaurant' : 'Create Restaurant'); ?>

                    </button>
                    <a href="/admin/restaurants" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const form = document.getElementById('restaurant-form');
const existingCategoryIds = <?php echo json_encode($restaurant->categories->pluck('id') ?? [], 15, 512) ?>;

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
    
    const payload = {
        name: form.name.value.trim(),
        address: form.address.value.trim(),
        city: form.city.value.trim(),
        region: form.region.value.trim(),
        country: form.country.value.trim(),
        postcode: form.postcode.value.trim(),
        website: form.website.value.trim() || null,
        opening_hours: form.opening_hours.value.trim() || null,
        category_ids: categoryIds
    };
    
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/restaurant_form.blade.php ENDPATH**/ ?>