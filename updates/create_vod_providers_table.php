<?php namespace Ffte\Movies\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateVodProvidersTable extends Migration
{
    public function up()
    {
        Schema::create('ffte_movies_vod_providers', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->required();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ffte_movies_vod_providers');
    }
}
