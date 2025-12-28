@extends('admin.layout')

@section('title', isset($user) && $user->id ? 'Edit User' : 'Create User')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ isset($user) && $user->id ? 'Edit User' : 'Create User' }}</h1>
            <p class="page-subtitle">{{ isset($user) && $user->id ? 'Update user details' : 'Add a new website user' }}</p>
        </div>
        <a href="/admin/users" class="btn btn-secondary">
            ← Back to Users
        </a>
    </div>

    <div class="card">
        <form id="user-form" class="form-grid">
            <div class="form-group">
                <label for="name" class="form-label">Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-input" required
                       value="{{ isset($user) ? $user->name : '' }}" placeholder="Enter full name">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" class="form-input" required
                       value="{{ isset($user) ? $user->email : '' }}" placeholder="Enter email address">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    Password {{ isset($user) && $user->id ? '(leave blank to keep current)' : '' }}
                    @if(!isset($user) || !$user->id)<span class="required">*</span>@endif
                </label>
                <input type="password" id="password" name="password" class="form-input"
                       {{ !isset($user) || !$user->id ? 'required' : '' }} placeholder="Enter password" minlength="6">
            </div>

            <div class="form-group">
                <label for="password_confirm" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-input"
                       placeholder="Confirm password">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submit-btn">
                    {{ isset($user) && $user->id ? 'Update User' : 'Create User' }}
                </button>
                <a href="/admin/users" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
const userId = {{ isset($user) && $user->id ? $user->id : 'null' }};
const isEdit = userId !== null;

document.getElementById('user-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    
    if (!name) {
        alert('Name is required');
        return;
    }
    
    if (!email) {
        alert('Email is required');
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
        const data = { name, email };
        if (password) {
            data.password = password;
        }
        
        if (isEdit) {
            await adminFetch('PUT', `/admin/api/users/${userId}`, data);
        } else {
            await adminFetch('POST', '/admin/api/users', data);
        }
        
        window.location.href = '/admin/users';
    } catch (err) {
        alert('Failed to save user: ' + (err.message || 'Unknown error'));
        submitBtn.disabled = false;
        submitBtn.textContent = isEdit ? 'Update User' : 'Create User';
    }
});
</script>
@endpush
