<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateFfteMoviesRightsholders extends Migration
{
    public function up()
    {
        Schema::table('ffte_movies_rightsholders', function($table)
        {
            $table->string('url')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('ffte_movies_rightsholders', function($table)
        {
            $table->dropColumn('url');
        });
    }
}
