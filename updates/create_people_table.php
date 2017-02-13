<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePeopleTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_people', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('ffte_movies_movie_person', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('movie_id')->required()->index();
            $table->integer('person_id')->required()->index();
            $table->integer('role_id')->required()->index();
            $table->primary(['movie_id', 'person_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_movie_person');
        Schema::dropIfExists('ffte_movies_people');
    }
}
