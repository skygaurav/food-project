@extends('admin.layout')

@section('title', isset($user) && $user->id ? 'Edit User' : 'New User')

@section('content')
    <div class="breadcrumb">
        <a href="/admin">Dashboard</a>
        <span>›</span>
        <a href="/admin/users">Website Users</a>
        <span>›</span>
        <span>{{ isset($user) && $user->id ? 'Edit' : 'New' }}</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ isset($user) && $user->id ? 'Edit Website User' : 'Create New Website User' }}</h1>
            <p class="page-subtitle">{{ isset($user) && $user->id ? 'Update user account details' : 'Add a new website user account' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="user-form">
                <input type="hidden" name="id" value="{{ $user->id ?? '' }}" />
                
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #475569;">User Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" value="{{ $user->name ?? '' }}" class="form-control" placeholder="Enter full name" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email <span style="color: #ef4444;">*</span></label>
                        <input type="email" name="email" value="{{ $user->email ?? '' }}" class="form-control" placeholder="Enter email address" required />
                    </div>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: #475569;">Password{{ isset($user) && $user->id ? ' (leave blank to keep current)' : '' }}</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password @if(!isset($user) || !$user->id)<span style="color: #ef4444;">*</span>@endif</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" minlength="6" {{ !isset($user) || !$user->id ? 'required' : '' }} />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirm" class="form-control" placeholder="Confirm password" />
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <span>💾</span> {{ isset($user) && $user->id ? 'Update User' : 'Create User' }}
                    </button>
                    <a href="/admin/users" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const form = document.getElementById('user-form');
const isEdit = form.id.value !== '';

form.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const password = form.password.value;
    const passwordConfirm = form.password_confirm.value;
    
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
    submitBtn.innerHTML = '<span>⏳</span> Saving...';
    
    try {
        const data = { name, email };
        if (password) {
            data.password = password;
        }
        
        if (isEdit) {
            await adminFetch('PUT', `/admin/api/users/${form.id.value}`, data);
        } else {
            await adminFetch('POST', '/admin/api/users', data);
        }
        
        window.location.href = '/admin/users';
    } catch (err) {
        alert('Failed to save user: ' + (err.message || 'Unknown error'));
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>💾</span> ' + (isEdit ? 'Update User' : 'Create User');
    }
});
</script>
@endpush
