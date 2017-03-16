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

        $this->makeRelation('country');
        $this->makeRelation('shooting_location');
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_movie_country');
        Schema::dropIfExists('ffte_movies_movie_shooting_location');
        Schema::dropIfExists('ffte_movies_countries');
    }

    private function makeRelation($name) {
        Schema::create("ffte_movies_movie_{$name}", function($table) {
            $table->integer('movie_id');
            $table->integer('country_id');
            $table->primary(['movie_id', 'country_id']);
        });
    }
}
