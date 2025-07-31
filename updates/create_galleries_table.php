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
            $table->json('images')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Carousel settings
            $table->integer('carousel_height')->default(400);
            $table->boolean('auto_play')->default(false);
            $table->boolean('show_dots')->default(true);
            $table->boolean('show_arrows')->default(true);
            $table->integer('autoplay_speed')->default(4000);
            $table->boolean('pause_on_hover')->default(true);
            
            // Masonry settings
            $table->integer('masonry_columns')->default(3);
            $table->integer('images_per_page')->default(9);
            $table->string('load_more_text')->default('Se flere bilder →');
            $table->boolean('show_image_titles')->default(true);
            $table->boolean('enable_lightbox')->default(true);
            $table->string('image_hover_effect')->default('zoom');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('egerstudios_imagegallery_galleries');
    }
}