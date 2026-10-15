<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');

        // Horizon::night();
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        $env = app()->environment();
        \Illuminate\Support\Facades\Log::debug('Horizon gate evaluated', ['env' => $env]);
        if (! \Illuminate\Support\Facades\Gate::has('viewHorizon')) {
            \Illuminate\Support\Facades\Gate::define('viewHorizon', static function (?\App\Models\User $user = null) {
                return app()->environment(config('extras.targets'));
            });
        }
    }
}
