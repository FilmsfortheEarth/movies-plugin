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
            $table->string('thumbnail_url')->nullable();
            $table->integer('duration')->nullable();
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

        Schema::create('ffte_movies_clip_language_audio', function(Blueprint $table) {
            $table->integer('clip_id');
            $table->integer('language_id');
            $table->primary(['clip_id', 'language_id']);
        });

        Schema::create('ffte_movies_clip_language_subtitle', function(Blueprint $table) {
            $table->integer('clip_id');
            $table->integer('language_id');
            $table->primary(['clip_id', 'language_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_clips');
        Schema::dropIfExists('ffte_movies_clippables');
        Schema::dropIfExists('ffte_movies_clip_language_audio');
        Schema::dropIfExists('ffte_movies_clip_language_subtitle');
    }
}
