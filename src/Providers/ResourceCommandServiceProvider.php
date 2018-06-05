<?php

namespace Kazmi\Commands;

use Illuminate\Support\ServiceProvider;

class ResourceCommandServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Kazmi\Resource\Commands\ApiMainCommandResource',
        'Kazmi\Resource\Commands\ApiControllerResourceCommand',
        'Kazmi\Resource\Commands\ApiRepositoryResourceCommand',
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
