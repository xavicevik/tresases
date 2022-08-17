<?php

namespace App\Http\Middleware;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                $permissions = [];
                //$users = Auth::user()->getAllPermissions();
                //dd($users);
                if (Auth::user()) {
                    foreach (Auth::user()->getAllPermissions() as $permission) {
                        $permissions[] = $permission->name;
                    }
                }

                return [
                    'user' => $request->user() ? : null,
                    'empresa' => $request->user()? Empresa::where('id', Auth::user()->idempresa)->get(): (object) [],
                    'puntoventa' => Session::get('puntodeventa')? : null,
                    'caja' => Session::get('caja')? : null,
                    'permissions' => json_encode($permissions)
                ];
            },
            'cart' => function () use ($request) {
                if ($request->user()) {
                    \Cart::session(Auth::user()->id);
                    $items = \Cart::getContent();
                } else {
                    $items = (object) [];
                }

                return [
                    'cart' => $items,
                ];
            },
        ]);
    }
}
