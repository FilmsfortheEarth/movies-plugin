<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMediaProvidersTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_media_providers', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->required();
            $table->text('embed_url_video')->nullable();
            $table->text('embed_url_image')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_media_providers');
    }
}
