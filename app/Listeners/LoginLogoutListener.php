<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

class LoginLogoutListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(protected Request $request)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($event instanceof Login) {
            $this->handleLogin($event);
        } elseif ($event instanceof Logout) {
            $this->handleLogout($event);
        }
    }

    /**
     * Handle user login
     */
    protected function handleLogin(Login $event): void
    {
        ActivityLog::create([
            'user_id' => $event->user->id,
            'action' => 'login',
            'description' => 'User logged into the system',
            'route' => $this->request->getPathInfo(),
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'login_time' => now(),
            'status' => 'active',
        ]);
    }

    /**
     * Handle user logout
     */
    protected function handleLogout(Logout $event): void
    {
        if (!$event->user) {
            return;
        }

        // Find the latest active login session for this user
        $lastLogin = ActivityLog::where('user_id', $event->user->id)
            ->where('action', 'login')
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($lastLogin) {
            // Update the login record with logout time
            $lastLogin->update([
                'logout_time' => now(),
                'status' => 'logged_out',
                'description' => 'User logged out of the system',
            ]);
        } else {
            // If no active login found, create a logout record anyway
            ActivityLog::create([
                'user_id' => $event->user->id,
                'action' => 'logout',
                'description' => 'User logged out of the system',
                'route' => $this->request->getPathInfo(),
                'ip_address' => $this->request->ip(),
                'user_agent' => $this->request->userAgent(),
                'logout_time' => now(),
                'status' => 'logged_out',
            ]);
        }
    }
}
