@extends('layouts.frontend')

@section('title', 'Register')

@push('styles')
<style>
    .auth-container {
        max-width: 420px;
        margin: 0 auto;
    }
    
    .auth-card {
        background: #fff;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .auth-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .auth-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }
    
    .auth-subtitle {
        color: var(--text-muted);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }
    
    .auth-form .form-group {
        margin-bottom: 1.25rem;
    }
    
    .auth-form .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    
    .auth-form .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        color: var(--text-dark);
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .auth-form .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(232, 93, 4, 0.1);
    }
    
    .auth-btn {
        width: 100%;
        padding: 1rem;
        font-size: 1rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }
    
    .auth-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #dc2626;
        font-size: 0.875rem;
    }
    
    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    
    .auth-footer a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
    }
    
    .auth-footer a:hover {
        text-decoration: underline;
    }
    
    .form-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }
</style>
@endpush

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon"><svg class="icon icon-3xl icon-primary"><use href="#icon-utensils"></use></svg></div>
                <h1 class="auth-title">Join FOODCITA</h1>
                <p class="auth-subtitle">Create an account to share your favorite dishes</p>
            </div>
            
            @if ($errors->any())
                <div class="auth-error">
                    @foreach ($errors->all() as $error)
                        <p style="margin: 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="/register" class="auth-form" id="register-form" novalidate>
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="form-control" placeholder="John Doe">
                    <div class="form-error"></div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                           class="form-control" placeholder="you@example.com">
                    <div class="form-error"></div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" 
                           class="form-control" placeholder="••••••••">
                    <p class="form-hint">Must be at least 6 characters</p>
                    <div class="form-error"></div>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="form-control" placeholder="••••••••">
                    <div class="form-error"></div>
                </div>
                
                <button type="submit" class="btn btn-primary auth-btn">
                    <svg class="icon"><use href="#icon-rocket"></use></svg> Create Account
                </button>
            </form>
            
            <div class="auth-footer">
                Already have an account? <a href="/login">Sign in</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('register-form');
    const V = window.SmartValidator;
    
    const validations = {
        name: [
            (v) => V.rules.required(v, 'Full name is required'),
            (v) => V.rules.minLength(v, 2, 'Name must be at least 2 characters')
        ],
        email: [
            (v) => V.rules.required(v, 'Email address is required'),
            (v) => V.rules.email(v, 'Please enter a valid email address')
        ],
        password: [
            (v) => V.rules.required(v, 'Password is required'),
            (v) => V.rules.minLength(v, 6, 'Password must be at least 6 characters')
        ],
        password_confirmation: [
            (v) => V.rules.required(v, 'Please confirm your password'),
            (v) => V.rules.match(v, document.getElementById('password').value, 'Passwords do not match')
        ]
    };
    
    V.attachLiveValidation(form, validations);
    
    form.addEventListener('submit', function(e) {
        if (!V.validateForm(form, validations)) {
            e.preventDefault();
            const firstError = form.querySelector('.form-group.has-error input');
            if (firstError) firstError.focus();
        }
    });
});
</script>
@endpush
