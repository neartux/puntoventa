<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsCajasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('movements_caja', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned();
            $table->integer('movement_type_id')->unsigned();
            $table->integer('reason_withdrawal_caja_id')->unsigned()->nullable();
            $table->integer('sale_id')->unsigned()->nullable();
            $table->integer('caja_id')->unsigned();
            $table->double('amount', 8, 2);
            $table->string('reference', 100);
            $table->dateTime('created_at');
            $table->text('comments')->nullable();

            $table->foreign('status_id')->references('id')->on('status')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('movement_type_id')->references('id')->on('movement_types')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reason_withdrawal_caja_id')->references('id')->on('reason_withdrawal_caja')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sale_id')->references('id')->on('sales')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('caja_id')->references('id')->on('caja')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('movements_caja');
    }
}
