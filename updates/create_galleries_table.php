<?php
// plugins/egerstudios/imagegallery/updates/create_galleries_table.php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateGalleriesTable extends Migration
{
    public function up()
    {
        Schema::create('egerstudios_imagegallery_galleries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('layout', ['carousel', 'masonry'])->default('carousel');
            $table->json('settings')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('egerstudios_imagegallery_galleries');
    }
}