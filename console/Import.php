<?php namespace Ffte\Movies\Console;

use Exception;
use Ffte\Movies\Models\Medium;
use Ffte\Movies\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ffte\Movies\Models\Movie;
use System\Models\File;

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

    protected $signature = 'movies:import {url=http://filmefuerdieerde.ch/de/api/movies}';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $url = $this->argument('url');
        $movies = json_decode(file_get_contents($url), true);
        $tags = [];
        foreach($movies as $movie) {
            $tags = array_merge($tags, $movie['tags']);
        }

        foreach($tags as $tag) {
            Tag::updateOrCreate(['id' => $tag['id']], [
                'name' => $tag['name'],
                'slug' => slugify($tag['name'])
            ]);
        }

        foreach($movies as $movie) {
            $tags = array_merge($tags, $movie['tags']);

            $model = Movie::updateOrCreate(['id' => $movie['id']], [
                'id' => $movie['id'],
                'title' => $movie['title'],
                'slug' => slugify($movie['title']),
                'subtitle' => $movie['subtitle'],
                'description' => $movie['description'],
                'notes' => $movie['notes'],
                'jury_rating' => $movie['jury_rating'],
                'other_rating' => $movie['other_rating'],
                'technical_info' => $movie['technical_info'],
                'links' => $movie['links'],
                'seo_title' => $movie['seo_title'],
                'seo_description' => $movie['seo_description'],
                'seo_keywords' => implode(',', $movie['seo_keywords']),
                'updated_at' => $movie['updated_at'],
                'created_at' => $movie['created_at'],
            ]);

            $model->tags = array_column($movie['tags'], 'id');

            $cover = getFile($movie['cover']);
            if($cover != null) {
                $model->cover = $cover;
            }

            $backgrounds = array_map(function($url) { return getFile($url); }, $movie['backgrounds']);
            $model->backgrounds()->delete();
            foreach($backgrounds as $background) {
                if($background != null) {
                    $model->backgrounds()->add($background);
                }
            }

            $images = array_map(function($url) { return getFile($url); }, $movie['images']);
            $model->images()->delete();
            foreach($images as $image) {
                if($image != null) {
                    $model->images()->add($image);
                }
            }

            $model->media()->delete();

            foreach($movie['movies'] as $m) {
                $medium = new Medium();
                $medium->title = $m['title'];
                $medium->url = $m['url'];
                $medium->provider = $m['provider'];
                $medium->movie = $model;
                $model->media()->add($medium);
            }

            $model->save();

            $this->info($model->id.' '.$model->title);
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

function getFile($url) {
    $local_url = base_path().'\\data\\'.$url;

    // if file doesn't exists, download
    if(!file_exists($local_url)) {
        try {
            $data = file_get_contents("http://filmefuerdieerde.org/files/".$url);
            file_put_contents($local_url, $data);
        } catch(Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    // create file from local data
    $file = new File;
    $file->fromFile($local_url);
    return $file;
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