<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLinksTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_links', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('url');

            $table->integer('movie_id')->index();
            $table->integer('linktype_id')->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_links');
    }
}
