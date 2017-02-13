<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateVodServicesTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_vod_services', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('vod_provider_id')->required();
            $table->integer('movie_id')->required();
            $table->string('url')->required();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_vod_services');
    }
}
