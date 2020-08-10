<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use App\User;

class Cors
{
    protected $_RESPONSE = array('status' => false, 'message' => '', 'data' => array());
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->hasHeader('x-token-x')) {
            return response()->jsonError(false, "Unauthorized",['header' => 'header user tidak di ketahui!']);
        }

        $token = $request->header('x-token-x');
        $user = DB::connection('sqlsrv_sms')->table('akun')->where('api_token', '=', $token)->first();

        if (!$user) {
            return response()->jsonError(false, "Token user tidak diketahui", ['x-token-x' => 'Token user Tidak di ketahui!']);
        }

        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'x-token-x, X-Requested-With, Content-Type, X-Token-Auth, Authorization');
    }
}
