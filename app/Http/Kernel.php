<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // In app/Http/Kernel.php
protected $routeMiddleware = [
    // Other middleware...
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'faculty' => \App\Http\Middleware\FacultyMiddleware::class,
    'student' => \App\Http\Middleware\StudentMiddleware::class,
];

protected $middlewareAliases = [
    // Other middleware...
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'faculty' => \App\Http\Middleware\FacultyMiddleware::class,
    'student' => \App\Http\Middleware\StudentMiddleware::class,
];
}