<?php

namespace Kazmi\Providers;

use Illuminate\Support\ServiceProvider;

class ResourceCommandServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Kazmi\Commands\ApiMainResourceCommand',
        'Kazmi\Commands\ApiControllerResourceCommand',
        'Kazmi\Commands\ApiRepositoryResourceCommand',
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
