<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Utente;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function validateLogin(Request $request)
    {
        $request->validate([
            'nome_utente' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function login(Request $request)
    {
        $default = '/';

        $user = Utente::where('password', $request->password)
            ->where('nome_utente', $request->nome_utente)
            ->first();

        if($user) {
            Auth::login($user);
            if(Auth::user()) {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['username' => 'Credenziali Errate']);
        }
    }

    protected function credentials(Request $request)
    {
        return $request->only( 'nome_utente', 'password');
    }

    public function authenticated(Request $request)
    {
        $credentials = $this->credentials($request);

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }
}
