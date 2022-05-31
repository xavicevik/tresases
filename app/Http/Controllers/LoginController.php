<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Puntoventa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Symfony\Component\Console\Input\Input;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;


class LoginController extends Controller
{
    use PasswordValidationRules;

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = csrf_token();
        return Inertia::render('Auth/Logincustom', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            '_token' => $token
        ]);
    }

    public function indexVendedor()
    {
        $token = csrf_token();
        return Inertia::render('Auth/Loginvendedor', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            '_token' => $token
        ]);
    }

    public function authenticate(Request $request)
    {
        $token = csrf_token();
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        $rol = User::where('username', $credentials['username'])
                    ->with('empresa.puntosventa')
                    ->first();

        if (! is_null($rol) && !isset($rol->changedpassword)) {
            return Inertia::render('Auth/Cambiarpassword', [
                'puntoventas' => $rol['empresa']['puntosventa'],
                'username' => $request->username,
                'password' => $request->password,
                '_token' => $token
            ]);
        }

        if (! is_null($rol) && $rol['idrol'] == 5) {
            return Inertia::render('Auth/Loginvendedor', [
                'puntoventas' => $rol['empresa']['puntosventa'],
                'username' => $request->username,
                'password' => $request->password,
                '_token' => $token
            ]);
        }

        if (Auth::attempt($credentials, ($request->remember == 'on') ? true : false)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function authenticatevendedor(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, ($request->remember == 'on') ? true : false)) {
            $request->session()->regenerate();
            $request->session()->push('puntodeventa', $request['puntodeventa']);

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function changePassword(Request $request)
    {
        $token = csrf_token();
        return Inertia::render('Auth/Cambiarpassword', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            '_token' => $token
        ]);
    }


    /**
     * Validate and update the user's password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function updatePassword(Request $request)
    {
        $mytime= Carbon::now('America/Bogota');
        $input = $request;
        $user = User::where('username', $input->username)->first();
        Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->after(function ($validator) use ($user, $input) {
            if (! isset($input->current_password) ) {
                $validator->errors()->add('current_password', __('Debe ingresar el password actual.'));
            }
            if ( Hash::check($input->password, $user->password)) {
                $validator->errors()->add('password', __('El password actual no puede ser igual al anterior'));
            }
        })->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input->password),
            'changedpassword' => $mytime->toDateString()
        ])->save();

        return redirect()->back()
            ->with('message', 'Se cambia contraseña');
        //return redirect()->route('login');
    }

    public function updatePasswordsu(Request $request)
    {
        $mytime= Carbon::now('America/Bogota');
        $input = $request;
        $user = User::where('id', $input->id)->first();

        Validator::make($request->all(), [
            'password' => $this->passwordRules(),
        ])->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input->password),
            'changedpassword' => $mytime->toDateString()
        ])->save();

        return redirect()->back()
            ->with('message', 'Se cambia contraseña');
    }



}
