<?php

namespace App\Listeners;

use App\Models\AuthLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Request;

class LogAuthActivity
{
    /**
     * Handle login event.
     */
    public function handleLogin(Login $event): void
    {
        AuthLog::create([
            'user_id'   => $event->user->id,
            'ip_address'=> Request::ip(),
            'user_agent'=> Request::userAgent(),
            'event'     => 'login',
            'logged_at' => now(),
        ]);
    }

    /**
     * Handle logout event.
     */
    public function handleLogout(Logout $event): void
    {
        AuthLog::create([
            'user_id'   => $event->user->id ?? null,
            'ip_address'=> Request::ip(),
            'user_agent'=> Request::userAgent(),
            'event'     => 'logout',
            'logged_at' => now(),
        ]);
    }

    /**
     * Handle failed login event.
     */
    public function handleFailed(Failed $event): void
    {
        AuthLog::create([
            'user_id'   => $event->user?->id, // kalau user tidak ketemu biarkan null
            'ip_address'=> Request::ip(),
            'user_agent'=> Request::userAgent(),
            'event'     => 'failed_login',
            'logged_at' => now(),
        ]);
    }
}
