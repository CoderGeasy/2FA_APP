<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorTokenMail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;



class TwoFactorController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showVerifyForm()
    {
        return view('auth.verify-2fa');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'token' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();

        if (
            $user->token === $request->token &&
            $user->token_expires_at->isFuture()
        ) {
            // Limpiar el token después de la verificación
            $user->update([
                'token' => null,
                'token_expires_at' => null,
            ]);
            return redirect()->intended('/home'); // Redirige al área protegida
        }

        return back()->withErrors(['token' => 'El token es inválido o ha expirado.']);
    }

    public function resend()
    {
        $user = Auth::user();

        if ($user->token && $user->token_expires_at->isFuture()) {
            return back()->with('status', 'Ya tienes un token activo. Revisa tu correo.');
        }

        // Generar nuevo token
        $token = rand(100000, 999999);
        $user->token = $token;
        $user->token_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new TwoFactorTokenMail($token));

        return back()->with('status', 'El token ha sido reenviado.');
    }
}