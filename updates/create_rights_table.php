<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRightsTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_rights', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('movie_id');
            $table->integer('rightsholder_id');
        });

        Schema::create('ffte_movies_right_country', function(Blueprint $table) {
            $table->integer('right_id');
            $table->integer('country_id');
            $table->primary(['right_id', 'country_id']);
        });

    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_rights');
        Schema::dropIfExists('ffte_movies_right_country');
    }
}
