<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRatiosTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_ratios', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('width');
            $table->integer('height');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_ratios');
    }
}
