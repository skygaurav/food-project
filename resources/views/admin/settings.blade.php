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
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 1rem; color: #475569;">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;"><use href="#icon-image"></use></svg>
                    Site Logo
                </h3>
                <div class="form-group">
                    <label class="form-label">Logo Image</label>
                    <div id="logo-preview-container" style="margin-bottom: 1rem;">
                        <img id="logo-preview" src="" alt="Site Logo" style="max-height: 60px; display: none; background: #1e293b; padding: 0.5rem 1rem; border-radius: 8px;" />
                        <span id="no-logo-text" class="text-muted">No logo uploaded</span>
                    </div>
                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                        <input type="file" id="logo-file" accept="image/png,image/jpeg,image/svg+xml,image/webp" style="display: none;" onchange="uploadLogo(this)" />
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('logo-file').click()">
                            <svg class="icon"><use href="#icon-image"></use></svg> Upload Logo
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="remove-logo-btn" style="display: none;" onclick="removeLogo()">
                            Remove
                        </button>
                    </div>
                    <small class="text-muted" style="display: block; margin-top: 0.5rem;">Recommended: PNG or SVG with transparent background. Max 2MB.</small>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;"><use href="#icon-alert-triangle"></use></svg>
                    Maintenance Mode
                </h3>
                <div class="form-group">
                    <label class="toggle-switch">
                        <input type="checkbox" name="maintenance_mode" id="maintenance_mode" />
                        <span class="toggle-slider"></span>
                        <span class="toggle-label">Enable Maintenance Mode</span>
                    </label>
                    <small class="text-muted" style="display: block; margin-top: 0.5rem;">When enabled, the site will display a maintenance page to all visitors. Admin users can still access the admin panel.</small>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;"><use href="#icon-settings"></use></svg>
                    General Settings
                </h3>
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
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;"><use href="#icon-globe"></use></svg>
                    Social Media Links
                </h3>
                <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 1rem;">Add your social media profile URLs. Leave empty to hide the link in the footer.</p>
                
                <div class="form-group">
                    <label class="form-label">Facebook URL</label>
                    <input type="url" name="social_facebook" class="form-control" placeholder="https://facebook.com/yourpage" />
                </div>
                
                <div class="form-group">
                    <label class="form-label">Instagram URL</label>
                    <input type="url" name="social_instagram" class="form-control" placeholder="https://instagram.com/yourprofile" />
                </div>
                
                <div class="form-group">
                    <label class="form-label">Twitter / X URL</label>
                    <input type="url" name="social_twitter" class="form-control" placeholder="https://twitter.com/yourhandle" />
                </div>
                
                <div class="form-group">
                    <label class="form-label">YouTube URL</label>
                    <input type="url" name="social_youtube" class="form-control" placeholder="https://youtube.com/@yourchannel" />
                </div>
                
                <div class="form-group">
                    <label class="form-label">TikTok URL</label>
                    <input type="url" name="social_tiktok" class="form-control" placeholder="https://tiktok.com/@yourprofile" />
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;"><use href="#icon-mail"></use></svg>
                    Email / SMTP Settings
                </h3>
                <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 1rem;">Configure SMTP settings for sending emails. All fields are required for email functionality to work.</p>
                
                <div class="form-row" style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">SMTP Host</label>
                        <input type="text" name="smtp_host" class="form-control" placeholder="smtp.gmail.com or smtp.mailgun.org" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">SMTP Port</label>
                        <input type="number" name="smtp_port" class="form-control" placeholder="587" min="1" max="65535" />
                    </div>
                </div>
                
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">SMTP Username</label>
                        <input type="text" name="smtp_username" class="form-control" placeholder="your-email@gmail.com" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">SMTP Password</label>
                        <input type="password" name="smtp_password" class="form-control" placeholder="••••••••" />
                        <small class="text-muted">For Gmail, use an App Password</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Encryption</label>
                    <select name="smtp_encryption" class="form-control" style="width: auto;">
                        <option value="tls">TLS (Recommended)</option>
                        <option value="ssl">SSL</option>
                        <option value="">None</option>
                    </select>
                </div>
                
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">From Email Address</label>
                        <input type="email" name="mail_from_address" class="form-control" placeholder="noreply@yourdomain.com" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">From Name</label>
                        <input type="text" name="mail_from_name" class="form-control" placeholder="FOODCITA" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Admin Notification Email</label>
                    <input type="email" name="admin_notification_email" class="form-control" placeholder="admin@yourdomain.com" />
                    <small class="text-muted">Receives notifications when new dishes are submitted</small>
                </div>
                
                <div class="form-group" style="margin-top: 1rem;">
                    <button type="button" class="btn btn-secondary" onclick="testEmailSettings()">
                        <svg class="icon"><use href="#icon-mail"></use></svg> Send Test Email
                    </button>
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
            // Logo
            if (settings.site_logo) {
                document.getElementById('logo-preview').src = '/storage/' + settings.site_logo;
                document.getElementById('logo-preview').style.display = 'block';
                document.getElementById('no-logo-text').style.display = 'none';
                document.getElementById('remove-logo-btn').style.display = 'inline-flex';
            }
            form.maintenance_mode.checked = settings.maintenance_mode ? true : false;
            if (settings.site_name) form.site_name.value = settings.site_name;
            if (settings.items_per_page) form.items_per_page.value = settings.items_per_page;
            if (settings.default_dish_status) form.default_dish_status.value = settings.default_dish_status;
            if (settings.meta_title) form.meta_title.value = settings.meta_title;
            if (settings.meta_description) form.meta_description.value = settings.meta_description;
            if (settings.meta_keywords) form.meta_keywords.value = settings.meta_keywords;
            if (settings.image_width) form.image_width.value = settings.image_width;
            if (settings.image_height) form.image_height.value = settings.image_height;
            if (settings.social_facebook) form.social_facebook.value = settings.social_facebook;
            if (settings.social_instagram) form.social_instagram.value = settings.social_instagram;
            if (settings.social_twitter) form.social_twitter.value = settings.social_twitter;
            if (settings.social_youtube) form.social_youtube.value = settings.social_youtube;
            if (settings.social_tiktok) form.social_tiktok.value = settings.social_tiktok;
            // SMTP settings
            if (settings.smtp_host) form.smtp_host.value = settings.smtp_host;
            if (settings.smtp_port) form.smtp_port.value = settings.smtp_port;
            if (settings.smtp_username) form.smtp_username.value = settings.smtp_username;
            if (settings.smtp_password) form.smtp_password.value = settings.smtp_password;
            if (settings.smtp_encryption) form.smtp_encryption.value = settings.smtp_encryption;
            if (settings.mail_from_address) form.mail_from_address.value = settings.mail_from_address;
            if (settings.mail_from_name) form.mail_from_name.value = settings.mail_from_name;
            if (settings.admin_notification_email) form.admin_notification_email.value = settings.admin_notification_email;
        }
    } catch (e) {
        // Ignore - settings may not exist yet
    }
}

form.addEventListener('submit', async e => {
    e.preventDefault();
    const payload = {
        maintenance_mode: form.maintenance_mode.checked,
        site_name: form.site_name.value.trim(),
        items_per_page: parseInt(form.items_per_page.value),
        default_dish_status: form.default_dish_status.value,
        meta_title: form.meta_title.value.trim(),
        meta_description: form.meta_description.value.trim(),
        meta_keywords: form.meta_keywords.value.trim(),
        image_width: form.image_width.value ? parseInt(form.image_width.value) : null,
        image_height: form.image_height.value ? parseInt(form.image_height.value) : null,
        social_facebook: form.social_facebook.value.trim() || null,
        social_instagram: form.social_instagram.value.trim() || null,
        social_twitter: form.social_twitter.value.trim() || null,
        social_youtube: form.social_youtube.value.trim() || null,
        social_tiktok: form.social_tiktok.value.trim() || null,
        // SMTP settings
        smtp_host: form.smtp_host.value.trim() || null,
        smtp_port: form.smtp_port.value ? parseInt(form.smtp_port.value) : null,
        smtp_username: form.smtp_username.value.trim() || null,
        smtp_password: form.smtp_password.value || null,
        smtp_encryption: form.smtp_encryption.value || null,
        mail_from_address: form.mail_from_address.value.trim() || null,
        mail_from_name: form.mail_from_name.value.trim() || null,
        admin_notification_email: form.admin_notification_email.value.trim() || null
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

async function testEmailSettings() {
    const testEmail = prompt('Enter email address to send test email:');
    if (!testEmail) return;
    
    try {
        const result = await adminFetch('POST', '/admin/api/settings/test-email', { email: testEmail });
        if (result.success) {
            alert('Test email sent successfully! Check your inbox.');
        } else {
            alert('Failed to send test email: ' + (result.error || 'Unknown error'));
        }
    } catch (err) {
        alert('Failed to send test email: ' + (err.message || 'Unknown error'));
    }
}

async function uploadLogo(input) {
    if (!input.files || !input.files[0]) return;
    
    const file = input.files[0];
    if (file.size > 2 * 1024 * 1024) {
        alert('Logo file must be less than 2MB');
        return;
    }
    
    const formData = new FormData();
    formData.append('logo', file);
    
    try {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const res = await fetch('/admin/api/settings/upload-logo', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: formData
        });
        
        if (!res.ok) throw new Error('Upload failed');
        
        const data = await res.json();
        if (data.path) {
            document.getElementById('logo-preview').src = '/storage/' + data.path;
            document.getElementById('logo-preview').style.display = 'block';
            document.getElementById('no-logo-text').style.display = 'none';
            document.getElementById('remove-logo-btn').style.display = 'inline-flex';
            alert('Logo uploaded successfully!');
        }
    } catch (err) {
        alert('Failed to upload logo: ' + (err.message || 'Unknown error'));
    }
    
    input.value = '';
}

async function removeLogo() {
    if (!confirm('Are you sure you want to remove the logo?')) return;
    
    try {
        await adminFetch('POST', '/admin/api/settings/remove-logo');
        document.getElementById('logo-preview').src = '';
        document.getElementById('logo-preview').style.display = 'none';
        document.getElementById('no-logo-text').style.display = 'inline';
        document.getElementById('remove-logo-btn').style.display = 'none';
        alert('Logo removed successfully!');
    } catch (err) {
        alert('Failed to remove logo: ' + (err.message || 'Unknown error'));
    }
}

loadSettings();
</script>
@endpush
