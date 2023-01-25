<?php

namespace App\Http\Middleware;

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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $is_admin = false;
        $is_super_admin = false;
        $user = $request->user();
        if ($user) {
            $is_admin = $user->isAdmin();
            $is_super_admin = $user->isSuperAdmin();
        }
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
                'isAdmin' => $is_admin,
                'isSuperAdmin' => $is_super_admin,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'toast' => session('message')
        ]);
    }
}
