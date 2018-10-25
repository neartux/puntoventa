<?php
/**
 * User: ricardo
 * Date: 24/10/18
 * Time: 10:07 PM
 */

namespace App\Services\provider;


use Illuminate\Support\ServiceProvider;

class ProviderService extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('App\Repository\provider\ProviderInterface', 'App\Repository\provider\ProviderRepository');
    }
}