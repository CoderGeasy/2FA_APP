<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\TwoFactorTokenMail;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function login(Request $request)
    {
        // Validar los datos del formulario, incluyendo el reCAPTCHA
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Intentar autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();

            if (!$user instanceof \App\Models\User) {
                return back()->withErrors(['token' => 'Error en la autenticación. Intenta de nuevo.']);
            }

            // Generar token 2FA y enviarlo por correo
            $token = rand(100000, 999999);
            $user->token = Hash::make($token);
            $user->token_expires_at = now()->addMinutes(10);
            $user->save();

            Mail::to($user->email)->send(new TwoFactorTokenMail($token));

            // Redirigir a la verificación 2FA
            return redirect()->route('verify-2fa');
        }

        // Si las credenciales son incorrectas
        return back()->withErrors(['email' => 'Las credenciales no coinciden.'])->withInput();
    }

    protected function authenticated(Request $request, $user)
    {
        // Generar el token
        $token = rand(100000, 999999);
        $user->token = Hash::make($token);
        $user->token_expires_at = now()->addMinutes(10);
        $user->save();

        // Enviar el token por correo
        Mail::to($user->email)->send(new TwoFactorTokenMail($token));

        // Redirigir al formulario de verificación 2FA
        return redirect()->route('verify-2fa');
    }

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