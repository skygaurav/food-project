<?php $__env->startSection('title','Settings'); ?>

<?php $__env->startSection('content'); ?>
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
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <span>💾</span> Save Settings
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const form = document.getElementById('settings-form');

async function loadSettings() {
    try {
        const settings = await adminFetch('GET', '/admin/api/settings');
        if (settings) {
            if (settings.site_name) form.site_name.value = settings.site_name;
            if (settings.items_per_page) form.items_per_page.value = settings.items_per_page;
            if (settings.default_dish_status) form.default_dish_status.value = settings.default_dish_status;
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
        default_dish_status: form.default_dish_status.value
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/settings.blade.php ENDPATH**/ ?>