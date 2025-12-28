@extends('admin.layout')

@section('title','Settings')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Settings</h1>
            <p class="page-subtitle">Configure admin preferences and system settings</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">General Settings</h2>
        </div>
        <div class="card-body">
            <form id="settings-form">
                <div class="form-group">
                    <label class="form-label">Site Name</label>
                    <input type="text" name="site_name" class="form-control" placeholder="FOODCITA" />
                </div>
                
                <div class="form-group">
                    <label class="form-label">Items Per Page (Grids)</label>
                    <select name="items_per_page" class="form-control" style="width: auto;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Default Dish Status</label>
                    <select name="default_dish_status" class="form-control" style="width: auto;">
                        <option value="pending">Pending (Requires Approval)</option>
                        <option value="approved">Approved (Auto-approve)</option>
                    </select>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;"><use href="#icon-image"></use></svg>
                    Image Upload Settings
                </h3>
                <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 1rem;">Set dimensions for uploaded dish images. Leave empty to keep original dimensions.</p>
                
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Image Width (px)</label>
                        <input type="number" name="image_width" class="form-control" placeholder="e.g. 800" min="100" max="3000" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Image Height (px)</label>
                        <input type="number" name="image_height" class="form-control" placeholder="e.g. 600" min="100" max="3000" />
                    </div>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;"><use href="#icon-search"></use></svg>
                    Homepage SEO Settings
                </h3>
                <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 1rem;">These settings are used for the homepage and as fallback for CMS pages without SEO info.</p>
                
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" placeholder="FOODCITA - Discover Delicious Dishes" />
                    <small class="text-muted">Recommended: 50-60 characters</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3" placeholder="Share your favorite meals and explore dishes loved by food enthusiasts in your city."></textarea>
                    <small class="text-muted">Recommended: 150-160 characters</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" placeholder="food, dishes, restaurants, reviews, dining" />
                    <small class="text-muted">Comma-separated keywords</small>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon"><use href="#icon-save"></use></svg> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h2 class="card-title">Column Preferences</h2>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4">Column visibility preferences are saved per-user in your browser's local storage. Use the "Columns" button on each grid to customize visible columns.</p>
            
            <button type="button" class="btn btn-secondary" onclick="clearColumnPreferences()">
                Reset All Column Preferences
            </button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const form = document.getElementById('settings-form');

async function loadSettings() {
    try {
        const settings = await adminFetch('GET', '/admin/api/settings');
        if (settings) {
            if (settings.site_name) form.site_name.value = settings.site_name;
            if (settings.items_per_page) form.items_per_page.value = settings.items_per_page;
            if (settings.default_dish_status) form.default_dish_status.value = settings.default_dish_status;
            if (settings.meta_title) form.meta_title.value = settings.meta_title;
            if (settings.meta_description) form.meta_description.value = settings.meta_description;
            if (settings.meta_keywords) form.meta_keywords.value = settings.meta_keywords;
            if (settings.image_width) form.image_width.value = settings.image_width;
            if (settings.image_height) form.image_height.value = settings.image_height;
        }
    } catch (e) {
        // Ignore - settings may not exist yet
    }
}

form.addEventListener('submit', async e => {
    e.preventDefault();
    const payload = {
        site_name: form.site_name.value.trim(),
        items_per_page: parseInt(form.items_per_page.value),
        default_dish_status: form.default_dish_status.value,
        meta_title: form.meta_title.value.trim(),
        meta_description: form.meta_description.value.trim(),
        meta_keywords: form.meta_keywords.value.trim(),
        image_width: form.image_width.value ? parseInt(form.image_width.value) : null,
        image_height: form.image_height.value ? parseInt(form.image_height.value) : null
    };
    
    try {
        await adminFetch('POST', '/admin/api/settings', payload);
        alert('Settings saved successfully!');
    } catch (err) {
        alert('Failed to save settings: ' + err.message);
    }
});

function clearColumnPreferences() {
    if (!confirm('This will reset all your column visibility preferences. Continue?')) return;
    
    // Clear all column manager keys
    Object.keys(localStorage).forEach(key => {
        if (key.startsWith('admin_columns_')) {
            localStorage.removeItem(key);
        }
    });
    
    alert('Column preferences have been reset. Refresh the page to see default columns.');
}

loadSettings();
</script>
@endpush
