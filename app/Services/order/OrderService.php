<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 28/04/18
 * Time: 07:42 AM
 */

namespace App\Services\order;


use Illuminate\Support\ServiceProvider;

class OrderService extends ServiceProvider {

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
        $this->app->bind('App\Repository\order\OrderInterface', 'App\Repository\order\OrderRepository');
    }

}