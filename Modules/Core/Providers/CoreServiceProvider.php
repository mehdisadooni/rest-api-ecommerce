<?php

namespace Modules\Core\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    public function boot()
    {
        Response::macro('success', function($message, $data) {
            return response()->json([
                'status' => 1,
                'message' => $message,
                'data' => $data,
            ]);
        });
    }

}
