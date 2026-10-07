<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

/**
 * HTTP middleware configuration for recipe pages, saved recipes, and admin routes.
 */
class Kernel extends HttpKernel
{
	protected $middleware = [
		TrustProxies::class,
		HandleCors::class,
		PreventRequestsDuringMaintenance::class,
		ValidatePostSize::class,
		TrimStrings::class,
		ConvertEmptyStringsToNull::class,
	];

	protected $middlewareGroups = [
		'web' => [
			EncryptCookies::class,
			AddQueuedCookiesToResponse::class,
			StartSession::class,
			ShareErrorsFromSession::class,
			VerifyCsrfToken::class,
			SubstituteBindings::class,
		],

		'api' => [
			'throttle:api',
			SubstituteBindings::class,
		],
	];

	protected $middlewareAliases = [
		'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
		'can' => \Illuminate\Auth\Middleware\Authorize::class,
		'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
		'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
		'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
		'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
	];
}
