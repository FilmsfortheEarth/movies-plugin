<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMediaTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_media', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('title');
            $table->string('url');
            $table->string('provider');

            $table->integer('movie_id')->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_media');
    }
}
