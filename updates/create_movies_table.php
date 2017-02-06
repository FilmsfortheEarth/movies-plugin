<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMoviesTable extends Migration
{
    public function up()
    {

        Schema::create('ffte_movies_movies', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->required();
            $table->string('slug')->required();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->text('jury_rating')->nullable();
            $table->text('other_rating')->nullable();
            $table->text('technical_info')->nullable();
            $table->text('links')->nullable();


            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_movies');
    }
}
