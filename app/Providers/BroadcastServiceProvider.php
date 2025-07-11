<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (request()->is('api/*')) {
            Broadcast::routes(['middleware' => ['auth:jwt']]); // JWT za mobilni
        } else {
            Broadcast::routes(['middleware' => ['web']]); // Cookie/session auth za web (ili možeš staviti i bez auth)
        }
        require base_path('routes/channels.php');
    }
}
