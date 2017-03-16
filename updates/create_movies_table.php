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
            $table->boolean('published')->default(false);
            $table->string('title')->required();

            $table->string('original_title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->text('jury_rating')->nullable();
            $table->text('other_rating')->nullable();
            $table->text('technical_info')->nullable();
            $table->string('year')->nullable();
            $table->string('duration')->nullable();
            $table->string('image_ratio')->nullable();

            $table->text('org_links')->nullable();
            $table->text('availability')->nullable();

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();

            $table->float('stars_contents')->nullable();
            $table->float('stars_entertainment')->nullable();
            $table->float('stars_quality')->nullable();
            $table->float('stars_momentum')->nullable();
            $table->float('stars_craftsmanship')->nullable();

            $table->integer('ratio_id')->nullable();
            $table->integer('age_recommendation')->nullable();

            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_movies');
    }
}
