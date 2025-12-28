@extends('admin.layout')

@section('title', isset($admin) && $admin->id ? 'Edit Admin' : 'Create Admin')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ isset($admin) && $admin->id ? 'Edit Admin' : 'Create Admin' }}</h1>
            <p class="page-subtitle">{{ isset($admin) && $admin->id ? 'Update admin user details' : 'Add a new administrator' }}</p>
        </div>
        <a href="/admin/admins" class="btn btn-secondary">
            ← Back to Admins
        </a>
    </div>

    <div class="card">
        <form id="admin-form" class="form-grid">
            <div class="form-group">
                <label for="username" class="form-label">Username <span class="required">*</span></label>
                <input type="text" id="username" name="username" class="form-input" required
                       value="{{ isset($admin) ? $admin->username : '' }}" placeholder="Enter username">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    Password {{ isset($admin) && $admin->id ? '(leave blank to keep current)' : '' }}
                    @if(!isset($admin) || !$admin->id)<span class="required">*</span>@endif
                </label>
                <input type="password" id="password" name="password" class="form-input"
                       {{ !isset($admin) || !$admin->id ? 'required' : '' }} placeholder="Enter password" minlength="6">
            </div>

            <div class="form-group">
                <label for="password_confirm" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-input"
                       placeholder="Confirm password">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submit-btn">
                    {{ isset($admin) && $admin->id ? 'Update Admin' : 'Create Admin' }}
                </button>
                <a href="/admin/admins" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
const adminId = {{ isset($admin) && $admin->id ? $admin->id : 'null' }};
const isEdit = adminId !== null;

document.getElementById('admin-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    
    if (!username) {
        alert('Username is required');
        return;
    }
    
    if (!isEdit && !password) {
        alert('Password is required');
        return;
    }
    
    if (password && password !== passwordConfirm) {
        alert('Passwords do not match');
        return;
    }
    
    if (password && password.length < 6) {
        alert('Password must be at least 6 characters');
        return;
    }
    
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';
    
    try {
        const data = { username };
        if (password) {
            data.password = password;
        }
        
        if (isEdit) {
            await adminFetch('PUT', `/admin/api/admins/${adminId}`, data);
        } else {
            await adminFetch('POST', '/admin/api/admins', data);
        }
        
        window.location.href = '/admin/admins';
    } catch (err) {
        alert('Failed to save admin: ' + (err.message || 'Unknown error'));
        submitBtn.disabled = false;
        submitBtn.textContent = isEdit ? 'Update Admin' : 'Create Admin';
    }
});
</script>
@endpush
