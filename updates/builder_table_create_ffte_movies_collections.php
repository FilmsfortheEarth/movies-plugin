<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateFfteMoviesCollections extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_collections', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('quote')->nullable();
            $table->string('quote_author')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ffte_movies_collections');
    }
}