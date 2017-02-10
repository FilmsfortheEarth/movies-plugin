<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAvailabilitiesTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_availabilities', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('ffte_movies_availability_movie', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('movie_id')->required();
            $table->integer('availability_id')->required();
            $table->primary(['movie_id', 'availability_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_availability_movie');
        Schema::dropIfExists('ffte_movies_availabilities');
    }
}
