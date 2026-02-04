<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificaSessaoCliente
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(empty(session('contrato_para_assinar'))):
            config(['session.lifetime' => 30]);
            return redirect()->route('inicio');
        else:
            return $next($request);
        endif;
    }
}
