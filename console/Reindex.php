<?php namespace Ffte\Movies\Console;

use Ffte\Movies\Models\Movie;
use Illuminate\Console\Command;
use System\Models\File;


class Reindex extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'movies:reindex';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
       Movie::reindex();
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
