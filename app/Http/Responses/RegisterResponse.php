<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Cierra la sesión creada automáticamente por Fortify y redirige al login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        Auth::guard(config('fortify.guard'))->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Cuenta creada correctamente. Inicia sesión para continuar.',
                'redirect' => route('login'),
            ], 201);
        }

        return redirect()
            ->route('login')
            ->with('status', 'Tu cuenta fue creada correctamente. Ya puedes iniciar sesión.');
    }
}
