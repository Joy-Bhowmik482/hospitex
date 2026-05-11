<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Log activity after request is processed
        if (Auth::check()) {
            $this->logActivity($request, $response);
        }

        return $response;
    }

    /**
     * Log user activity
     */
    protected function logActivity(Request $request, Response $response)
    {
        $user = Auth::user();
        $route = $request->route();

        // Skip logging for certain routes
        $skipRoutes = [
            'activity-logs.index',
            'activity-logs.show',
            'activity-logs.login-history',
            'activity-logs.audit-trail',
        ];

        if ($route && in_array($route->getName(), $skipRoutes)) {
            return;
        }

        $action = $this->determineAction($request);
        $description = $this->generateDescription($request, $action);

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description,
            'route' => $request->getPathInfo(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Determine the action type based on HTTP method and route
     */
    protected function determineAction(Request $request): string
    {
        $method = $request->method();
        $route = $request->route();

        if (!$route) {
            return 'access';
        }

        $routeName = $route->getName();

        // Check for CRUD operations
        if (str_contains($routeName, '.store')) {
            return 'create';
        } elseif (str_contains($routeName, '.update')) {
            return 'update';
        } elseif (str_contains($routeName, '.destroy')) {
            return 'delete';
        } elseif (str_contains($routeName, '.show') && $this->isSensitiveData($routeName)) {
            return 'view_sensitive';
        } elseif ($method === 'GET' && str_contains($routeName, '.index')) {
            return 'list';
        } elseif ($method === 'GET' && str_contains($routeName, '.show')) {
            return 'view';
        }

        return 'access';
    }

    /**
     * Check if the route involves sensitive data
     */
    protected function isSensitiveData(string $routeName): bool
    {
        $sensitiveRoutes = [
            'patients.show',
            'doctors.show',
            'staff.show',
            'users.show',
            'invoices.show',
            'payments.show',
        ];

        return in_array($routeName, $sensitiveRoutes);
    }

    /**
     * Generate a human-readable description of the activity
     */
    protected function generateDescription(Request $request, string $action): string
    {
        $route = $request->route();

        if (!$route) {
            return "Accessed {$request->getPathInfo()}";
        }

        $routeName = $route->getName();
        $resource = $this->extractResourceName($routeName);

        switch ($action) {
            case 'create':
                return "Created a new {$resource}";
            case 'update':
                return "Updated {$resource} information";
            case 'delete':
                return "Deleted {$resource}";
            case 'view':
                return "Viewed {$resource} details";
            case 'view_sensitive':
                return "Viewed sensitive {$resource} data";
            case 'list':
                return "Viewed {$resource} list";
            default:
                return "Accessed {$resource} section";
        }
    }

    /**
     * Extract resource name from route name
     */
    protected function extractResourceName(string $routeName): string
    {
        $parts = explode('.', $routeName);
        $resource = $parts[0] ?? 'resource';

        // Convert plural to singular for better descriptions
        $singular = [
            'patients' => 'patient',
            'doctors' => 'doctor',
            'staff' => 'staff member',
            'wards' => 'ward',
            'rooms' => 'room',
            'beds' => 'bed',
            'appointments' => 'appointment',
            'invoices' => 'invoice',
            'payments' => 'payment',
            'users' => 'user',
            'roles' => 'role',
            'permissions' => 'permission',
        ];

        return $singular[$resource] ?? str_replace(['_', '-'], ' ', $resource);
    }
}
