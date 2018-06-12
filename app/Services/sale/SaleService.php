<?php
/**
 * User: ricardo
 * Date: 19/03/18
 */

namespace App\Services\sale;

use Illuminate\Support\ServiceProvider;

class SaleService extends ServiceProvider {

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
        $this->app->bind('App\Repository\sale\SaleInterface', 'App\Repository\sale\SaleRepository');
    }
}