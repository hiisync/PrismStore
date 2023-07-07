<?php

namespace App\Http\Middleware;

use App\Models\Navigation;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'navbar' => Navigation::where('type', 'navbar')->get()->toArray(),
            'footer' => Navigation::where('type', 'footer')->get()->toArray(),
            'auth' => ['user' => $request->user() ? $request->user()->only('id', 'balance', 'name', 'email') : null,
                'can' => $request->user() ? $request->user()->getPermissionArray() : [],
            ],
            'user.roles' => $request->user() ? $request->user()->roles->pluck('name') : [],
            'user.permissions' => $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name') : [],
            'appName' => config('app.name'),
            'locale' => session('locale') != null ? session('locale') : config('app.fallback_locale'),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'error' => fn () => $request->session()->get('error'),
            ],
        ]);
    }
}
