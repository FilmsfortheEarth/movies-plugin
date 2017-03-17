<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateFfteMoviesRightsholders extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_rightsholders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('ffte_movies_movie_rights', function($table)
        {
            $table->integer('rightsholder_id');
            $table->integer('movie_id');
            $table->primary(['rightsholder_id', 'movie_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ffte_movies_rightsholders');
        Schema::dropIfExists('ffte_movies_movie_rights');
    }
}
