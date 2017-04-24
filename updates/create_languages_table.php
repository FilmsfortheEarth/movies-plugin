<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLanguagesTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_languages', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique()->required();
        });

        $this->makeRelation('language_audio');
        $this->makeRelation('language_subtitle');
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_languages');
        Schema::dropIfExists('ffte_movies_movie_language_audio');
        Schema::dropIfExists('ffte_movies_movie_language_subtitle');
    }

    private function makeRelation($name)
    {
        Schema::create("ffte_movies_movie_{$name}", function(Blueprint $table) {
            $table->integer('movie_id');
            $table->integer('language_id');
            $table->primary(['movie_id', 'language_id']);
        });
    }
}
