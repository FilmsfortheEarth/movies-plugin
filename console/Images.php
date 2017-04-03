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
        $dir = base_path() . MediaLibrary::url('') . 'covers';
        $this->createDirectory($dir);
        $movies = Movie::all();

        $publicDir = storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;

        foreach ($movies as $movie) {
            if ($movie->cover != null) {
                $name = $movie->cover->disk_name;
                $file_name = $movie->cover->file_name;

                $one = substr($name, 0, 3);
                $two = substr($name, 3, 3);
                $three = substr($name, 6, 3);

                $source = $publicDir . $one . DIRECTORY_SEPARATOR . $two . DIRECTORY_SEPARATOR . $three . DIRECTORY_SEPARATOR . $name;
                $dest = $dir . DIRECTORY_SEPARATOR . $file_name;
                if(copy($source, $dest)) {
                    $movie->cover_url = "covers/{$file_name}";
                    $movie->save();
                }
            }
        }
    }

    private function createDirectory($dir)
    {
        if (!is_dir($dir)) {
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
