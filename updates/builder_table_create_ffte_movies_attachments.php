<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateFfteMoviesAttachments extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_attachments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('attachmenttype_id');
            $table->string('url');
            $table->string('title');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('movie_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ffte_movies_attachments');
    }
}
