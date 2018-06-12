<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->integer('deparment_id')->unsigned();
            $table->string('code', 100)->unique();
            $table->string('description', 100);
            $table->double('purchase_price', 8, 2);
            $table->double('sale_price', 8, 2);
            $table->double('wholesale_price', 8, 2);
            $table->dateTime('created_at');
            $table->double('current_stock', 8, 2);
            $table->double('minimum_stock', 8, 2);

            $table->foreign('status_id')->references('id')->on('status')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('unit_id')->references('id')->on('unities')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('deparment_id')->references('id')->on('deparments')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }
}
