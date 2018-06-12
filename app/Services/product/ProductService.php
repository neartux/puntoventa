<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 12/03/18
 * Time: 07:44 PM
 */

namespace App\Services\product;


use Illuminate\Support\ServiceProvider;

class ProductService extends ServiceProvider {

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
        $this->app->bind('App\Repository\Product\ProductInterface', 'App\Repository\Product\ProductRepository');
    }

}