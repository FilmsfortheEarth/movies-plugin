<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateFfteMoviesClipTypes extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_clip_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ffte_movies_clip_types');
    }
}
