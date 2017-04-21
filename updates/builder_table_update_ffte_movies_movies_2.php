<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateFfteMoviesMovies2 extends Migration
{
    public function up()
    {
        Schema::table('ffte_movies_movies', function($table)
        {
            $table->text('search_tags')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('ffte_movies_movies', function($table)
        {
            $table->dropColumn('search_tags');
        });
    }
}
