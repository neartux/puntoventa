<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned();
            $table->integer('personal_data_id')->unsigned();
            $table->integer('location_data_id')->unsigned();
            $table->string('user_name', 50)->unique();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('personal_data_id')->references('id')->on('personal_data')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('location_data_id')->references('id')->on('location_data')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
