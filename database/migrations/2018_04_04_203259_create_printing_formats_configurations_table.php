<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintingFormatsConfigurationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('printing_formats_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('printing_format_id')->unsigned();
            $table->double('header_x', 8, 2);
            $table->double('header_y', 8, 2);
            $table->double('header_size', 8, 2);
            $table->double('logo_x', 8, 2);
            $table->double('logo_y', 8, 2);
            $table->double('logo_size', 8, 2);
            $table->double('folio_x', 8, 2);
            $table->double('folio_y', 8, 2);
            $table->double('folio_size', 8, 2);
            $table->double('date_x', 8, 2);
            $table->double('date_y', 8, 2);
            $table->double('date_size', 8, 2);
            $table->double('body_x', 8, 2);
            $table->double('body_y', 8, 2);
            $table->double('body_size', 8, 2);
            $table->double('footer_x', 8, 2);
            $table->double('footer_y', 8, 2);
            $table->double('footer_size', 8, 2);

            $table->foreign('printing_format_id')->references('id')->on('printing_formats')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('printing_formats_configurations');
    }
}
