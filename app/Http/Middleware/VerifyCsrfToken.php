<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/make_payment', '/subscriber/sslcommerz/success','/subscriber/sslcommerz/cancel','/subscriber/sslcommerz/fail','/subscriber/sslcommerz/ipn'
    ];
}
