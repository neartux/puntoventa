<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('caja', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned();
            $table->integer('user_opening_id')->unsigned();
            $table->integer('user_close_id')->unsigned()->nullable();
            $table->dateTime('opening_date');
            $table->dateTime('close_date')->nullable();
            $table->double('opening_amount', 8, 2);
            $table->double('total_earnings', 8, 2);
            $table->double('total_withdrawals', 8, 2);
            $table->double('total_amount', 8, 2);
            $table->text('comments')->nullable();

            $table->foreign('status_id')->references('id')->on('status')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_opening_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_close_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('caja');
    }
}
