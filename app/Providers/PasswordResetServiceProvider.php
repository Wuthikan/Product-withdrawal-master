<?php
namespace DurianSoftware\Providers;

use DurianSoftware\Services\PasswordBrokerManager;
use Illuminate\Support\ServiceProvider;

class PasswordResetServiceProvider extends ServiceProvider
{
    protected $defer = true;
    public function register()
    {
        $this->registerPasswordBrokerManager();
    }

    protected function registerPasswordBrokerManager()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordBrokerManager($app);
        });

        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });
    }

    public function providers()
    {
        return ['auth.password', 'auth.password.broker'];
    }
}
