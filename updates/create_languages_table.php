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
            $table->string('code')->required();
            $table->string('name')->required();
            $table->timestamps();
        });

        Schema::create('ffte_movies_movie_language', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('movie_id');
            $table->integer('language_id');
            $table->primary(['movie_id', 'language_id']);
        });

    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_languages');
        Schema::dropIfExists('ffte_movies_movie_language');
    }
}
