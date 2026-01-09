<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google reCAPTCHA Keys
    |--------------------------------------------------------------------------
    |
    | These are the reCAPTCHA keys obtained from the Google reCAPTCHA Admin Console.
    | You can obtain your keys from: https://www.google.com/recaptcha/admin
    |
    | Choose reCAPTCHA v2 "I'm not a robot" Checkbox for best compatibility.
    |
    */

    'secret' => env('NOCAPTCHA_SECRET'),
    'sitekey' => env('NOCAPTCHA_SITEKEY'),

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable Captcha
    |--------------------------------------------------------------------------
    |
    | You can enable or disable captcha validation here. This is useful for
    | development/testing environments.
    |
    */

    'enabled' => env('CAPTCHA_ENABLED', true),
];
