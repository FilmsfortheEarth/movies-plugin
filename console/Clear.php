<?php namespace Ffte\Movies\Console;

use Illuminate\Console\Command;
use System\Models\File;


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
        File::truncate();
        \Ffte\Movies\Models\File::truncate();


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
