<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorTokenMail;


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
    protected $redirectTo = '/home';

    protected function authenticated(Request $request, $user)
    {
        // Generar el token
        $token = rand(100000, 999999); // Token de 6 dígitos
        $user->token = $token;
        $user->token_expires_at = now()->addMinutes(10); // Token válido por 10 minutos
        $user->save();

        // Enviar el token por correo
        Mail::to($user->email)->send(new TwoFactorTokenMail($token));

        // Redirigir al formulario de verificación 2FA
        return redirect()->route('verify-2fa');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function loggedOut(Request $request)
    {
        return redirect('/login');
    }
}