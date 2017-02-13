<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_countries', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->required();
            $table->string('name')->required();
            $table->timestamps();
        });

        Schema::create('ffte_movies_movie_country', function($table) {
            $table->engine = 'InnoDB';
            $table->integer('movie_id')->index();
            $table->integer('country_id')->index();
            $table->integer('mode')->default(0);
            $table->primary(['movie_id', 'country_id']);
        });
    }

    public function down()
    {
        Schema::dropIFExists('ffte_movies_movie_country');
        Schema::dropIfExists('ffte_movies_countries');
    }
}
