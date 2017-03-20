<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateFfteMoviesCategoryClip extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_category_clip', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('category_id');
            $table->integer('clip_id');
            $table->primary(['category_id','clip_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ffte_movies_category_clip');
    }
}