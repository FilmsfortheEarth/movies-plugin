<?php namespace Ffte\Movies\Updates;

use Ffte\Movies\Models\ClipType;
use October\Rain\Database\Updates\Seeder;

class SeedAllTables extends Seeder {

    public function run()
    {
        ClipType::create(['name' => 'Filmbeschreibung']);
    }
}