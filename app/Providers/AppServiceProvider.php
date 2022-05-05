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

        Inertia::share('userall', function () {
            $empresa = Empresa::where('id', '=', Auth::user()->idempresa)->get();

            return [
                $empresa
            ];
        });

        view()->composer('welcome', function($view) {
            $view->with('menus', Menu::menus());
        });
    }
}
