<?php
/**
 * User: ricardo
 * Date: 3/04/18
 */

namespace App\Services\user;


use Illuminate\Support\ServiceProvider;

class UserService extends ServiceProvider {

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
        $this->app->bind('App\Repository\user\UserInterface', 'App\Repository\user\UserRepository');
    }

}