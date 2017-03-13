<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_tags', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->required();
            $table->timestamps();
        });

        Schema::create('ffte_movies_taggables', function(Blueprint $table) {
            $table->integer('tag_id');
            $table->integer('taggable_id');
            $table->string('taggable_type');
            $table->primary(['tag_id', 'taggable_id', 'taggable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_tags');
        Schema::dropIfExists('ffte_movies_taggables');
    }
}
