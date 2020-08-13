<?php

namespace App\Providers;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('jsonSuccess', function($ok = true, $message = '', $data = null) use ($factory) {
            $format = [
                'ok' => $ok,
                'message' => $message,
                'result' => $data
            ];

            return $factory->make($format);
        });

        $factory->macro('success', function($ok = true, $message = '', $data = null) use ($factory) {
            $format = [
                'ok' => $ok,
                'message' => $message,
                'result' => $data
            ];

            return $factory->make($format);
        });

        $factory->macro('jsonError', function($ok = true, $message = '', $errors = []) use ($factory) {
            $format = [
                'ok' => $ok,
                'message' => $message,
                'errors' => $errors
            ];

            return $factory->make($format);
        });
    }
}
