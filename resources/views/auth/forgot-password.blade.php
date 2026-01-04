@extends('layouts.frontend')

@section('title', 'Forgot Password')

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
    
    .auth-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #16a34a;
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
</style>
@endpush

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon"><svg class="icon icon-3xl icon-primary"><use href="#icon-mail"></use></svg></div>
                <h1 class="auth-title">Forgot Password?</h1>
                <p class="auth-subtitle">Enter your email and we'll send you a link to reset your password</p>
            </div>
            
            @if (session('status'))
                <div class="auth-success">
                    {{ session('status') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="auth-error">
                    @foreach ($errors->all() as $error)
                        <p style="margin: 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="/forgot-password" class="auth-form" id="forgot-password-form" novalidate>
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                           class="form-control" placeholder="you@example.com">
                    <div class="form-error"></div>
                </div>
                
                <button type="submit" class="btn btn-primary auth-btn">
                    <svg class="icon"><use href="#icon-mail"></use></svg> Send Reset Link
                </button>
            </form>
            
            <div class="auth-footer">
                Remember your password? <a href="/login">Sign In</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgot-password-form');
    const V = window.SmartValidator;
    
    const validations = {
        email: [
            (v) => V.rules.required(v, 'Email address is required'),
            (v) => V.rules.email(v, 'Please enter a valid email address')
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
