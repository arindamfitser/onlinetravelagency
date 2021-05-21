<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'users/hotels/rooms/del/gallery',
        'users/hotels/del/image',
        'admin/hotels/rooms/del/gallery/en',
        'admin/hotels/del/image/en',
    ];
}
