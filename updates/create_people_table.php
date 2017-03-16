<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;


class CreatePeopleTable extends Migration
{
    private $names = ['director', 'script', 'production', 'music', 'actor'];

    public function up()
    {
        Schema::create('ffte_movies_people', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        foreach($this->names as $name) {
           $this->makeRelation($name);
        }
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_people');
        foreach($this->names as $name) {
            Schema::dropIfExists("ffte_movies_movie_person_{$name}");
        }
    }

    private function makeRelation($name) {
        Schema::create("ffte_movies_movie_person_{$name}", function(Blueprint $table) {
            $table->integer('movie_id');
            $table->integer('person_id');
            $table->primary(['movie_id', 'person_id']);
        });
    }

}
