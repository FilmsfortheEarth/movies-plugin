<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateFfteMoviesCategories2 extends Migration
{
    public function up()
    {
        Schema::table('ffte_movies_categories', function($table)
        {
            $table->dropColumn('published');
            $table->dropColumn('teaser_text');
            $table->dropColumn('text');
            $table->dropColumn('quote_text');
            $table->dropColumn('quote_author');
        });
    }
    
    public function down()
    {
        Schema::table('ffte_movies_categories', function($table)
        {
            $table->boolean('published')->default(0);
            $table->string('teaser_text', 255)->nullable();
            $table->text('text')->nullable();
            $table->text('quote_text')->nullable();
            $table->string('quote_author', 255)->nullable();
        });
    }
}