<?php

namespace App\Providers;

use App\Models\Empresa;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use App\Models\Menu;

use \Illuminate\Contracts\Auth\StatefulGuard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share([
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
        ]);

        Inertia::share('flash', function () {
            return [
                'message' => Session::get('message'),
                'status' => Session::get('status'),
                'error' => Session::get('error'),
            ];
        });
/*
        Inertia::share('userall', function () {
            $empresa = Auth::user()? Empresa::where('id', Auth::user()->idempresa)->get(): (object) [];

            return [
                'empresa' => $empresa,
                'puntoventa' => Session::get('puntodeventa')
            ];
        });

        Inertia::share('cart', function () {
            if (Auth::user()) {
                \Cart::session(Auth::user()->id);
                $items = \Cart::getContent();
            } else {
                $items = (object) [];
            }

            return [
                'cart' => $items,
            ];
        });
*/
    }
}
