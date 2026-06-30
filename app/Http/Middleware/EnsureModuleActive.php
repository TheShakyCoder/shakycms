<?php

namespace App\Http\Middleware;

use App\Modules\ModuleManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Route guard for module-gated features. Registered as the `module` alias,
 * used as `module:<key>` — e.g. `module:auth`. When the named module is
 * inactive the route behaves as if it does not exist (404).
 */
class EnsureModuleActive
{
    public function __construct(private ModuleManager $modules) {}

    public function handle(Request $request, Closure $next, string $key): Response
    {
        abort_unless($this->modules->isActive($key), 404);

        return $next($request);
    }
}
