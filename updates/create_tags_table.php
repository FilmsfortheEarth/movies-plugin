<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_tags', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->required();
            $table->string('slug')->required();

            $table->timestamps();
        });

        Schema::create('ffte_movies_movie_tag', function(Blueprint $table) {
            $table->integer('movie_id')->required();
            $table->integer('tag_id')->required();

            $table->primary(['tag_id', 'movie_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_tags');
        Schema::dropIfExists('ffte_movies_movie_tag');
    }
}
