<?php
/**
 * User: ricardo
 * Date: 28/04/18
 * Time: 11:06 AM
 */

namespace App\Services\client;


use Illuminate\Support\ServiceProvider;

class ClientService extends ServiceProvider {

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
        $this->app->bind('App\Repository\client\ClientInterface', 'App\Repository\client\ClientRepository');
    }

}