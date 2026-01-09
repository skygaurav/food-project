{{-- Google reCAPTCHA Widget --}}
@if(config('captcha.enabled', true) && config('captcha.sitekey'))
    <div class="form-group captcha-container" style="margin-bottom: 1.25rem;">
        {!! NoCaptcha::display() !!}
        @error('g-recaptcha-response')
            <div class="captcha-error" style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">
                {{ $message }}
            </div>
        @enderror
    </div>
@endif
