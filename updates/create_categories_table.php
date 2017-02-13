<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_categories', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');

            $table->timestamps();
        });

        Schema::create('ffte_movies_category_movie', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('movie_id')->required();
            $table->integer('category_id')->required();
            $table->primary(['movie_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_category_movie');
        Schema::dropIfExists('ffte_movies_categories');
    }
}
