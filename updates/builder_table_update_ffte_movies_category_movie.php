<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateFfteMoviesCategoryMovie extends Migration
{
    public function up()
    {
        Schema::table('ffte_movies_category_movie', function($table)
        {
            $table->boolean('tip')->default(0);
            $table->text('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('ffte_movies_category_movie', function($table)
        {
            $table->dropColumn('tip');
            $table->dropColumn('description');
        });
    }
}
