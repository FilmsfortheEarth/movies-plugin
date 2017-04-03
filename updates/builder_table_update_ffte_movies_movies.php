<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateFfteMoviesMovies extends Migration
{
    public function up()
    {
        Schema::table('ffte_movies_movies', function($table)
        {
            $table->text('cover_url')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('ffte_movies_movies', function($table)
        {
            $table->dropColumn('cover_url');
        });
    }
}
