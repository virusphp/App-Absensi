<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class Signature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->hasHeader('x-signature-x')) {
            return response()->jsonError(false, "Header access tidak diketahui!",['header' => 'header access tidak di ketahui']);
        }

        $token = $request->header('x-signature-x');
        $user = DB::connection('sqlsrv_sms')->table('akun')->where('api_token', '=', $token)->first();

        if (!$user) {
            return response()->jsonError(false, "Token access tidak diketahui", ['x-signature-x' => 'Token access Tidak di ketahui!']);
        }

        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'x-signature, x-token-x, X-Requested-With, Content-Type, X-Token-Auth, Authorization');
    }
}
