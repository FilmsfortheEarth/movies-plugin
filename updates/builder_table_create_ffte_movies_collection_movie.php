<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateFfteMoviesCollectionMovie extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_collection_movie', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('collection_id');
            $table->integer('movie_id');
            $table->boolean('tip')->default(0);
            $table->text('description')->nullable();
            $table->primary(['collection_id','movie_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ffte_movies_collection_movie');
    }
}
