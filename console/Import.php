<?php namespace Ffte\Movies\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ffte\Movies\Models\Movie;

class Import extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'movies:import';

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
        $client = new \GuzzleHttp\Client();
        $res = $client->get('https://filmefuerdieerde.org/filme/movie-list');
        $movies = json_decode($res->getBody(), true);
        foreach($movies as $movie) {           
            Movie::updateOrCreate(['id' => $movie['id']], [
                'title' => $movie['name'],
                'slug' => slugify($movie['name'])
            ]);    
        }
        
        echo 'ok';   
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

function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}