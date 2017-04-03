<?php namespace Ffte\Movies\Console;

use Cms\Classes\MediaLibrary;
use Ffte\Movies\Models\Movie;
use Illuminate\Console\Command;


class Images extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'movies:images';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    protected $signature = 'movies:images';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $this->createDirectory();
        $movies = Movie::all();

        echo public_path();

        foreach($movies as $movie) {
            $name = $movie->cover->disk_name;
            $one = substr($name, 0, 3);

        }
    }

    private function createDirectory()
    {
        $dir = base_path().MediaLibrary::url('').DIRECTORY_SEPARATOR.'covers';
        if(!is_dir($dir)) {
            mkdir($dir);
        }
    }

    /**
     * Get the console command $moviesments.
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
