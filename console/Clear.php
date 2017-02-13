<?php namespace Ffte\Movies\Console;

use Ffte\Movies\Models\Movie;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Clear extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'movies:clear';

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
        foreach(Movie::all() as $movie) {
            $movie->delete();
        }

        $this->output->writeln('done');
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
