<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateClipsTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_clips', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('url');
            $table->string('title');
            $table->integer('type_id')->nullable();

            $table->timestamps();
        });

        Schema::create('ffte_movies_clippables', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('clip_id')->required();
            $table->integer('clippable_id')->required();
            $table->string('clippable_type');
            $table->primary(['clip_id', 'clippable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_clips');
        Schema::dropIfExists('ffte_movies_clippables');
    }
}
