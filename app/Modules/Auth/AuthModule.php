<?php

namespace App\Modules\Auth;

use App\Contracts\Module;

/**
 * Authentication module.
 *
 * When active, the public site shows login/register links and the
 * register/password-reset pages and the internal dashboard are reachable.
 * The login/logout routes themselves are intentionally NOT gated by this
 * module, so an admin can never be locked out by deactivating it.
 *
 * Defaults to active so existing authentication keeps working on first deploy.
 */
class AuthModule implements Module
{
    public function key(): string
    {
        return 'auth';
    }

    public function name(): string
    {
        return 'Authentication';
    }

    public function description(): string
    {
        return 'User login & registration, and access to the internal dashboard.';
    }

    public function defaultActive(): bool
    {
        return true;
    }

    public function route(): ?string
    {
        // Auth has no single management page of its own.
        return null;
    }
}
