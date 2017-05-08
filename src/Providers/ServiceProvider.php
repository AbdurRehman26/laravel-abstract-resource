<?php

namespace Cygnis\Providers;

use Illuminate\Support\ServiceProvider;
use Hashids\Hashids;

class ServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/cygnis.php' => config_path('cygnis.php'),
        ]);
        Validator::resolver(function($translator, $data, $rules, $messages) {
            return new Validation($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Hashids', function ($app) {
            return new Hashids(config('cygnis.hashid.salt'), config('cygnis.hashid.min'));
        });
        $this->app->singleton('language',function(){
            if (request()->has('language') && request()->get('language')) {
                return request()->get('language');
            } else if (session()->has('language') && session()->get('language')) {
                return session()->get('language');
            }
        });
    }
}
