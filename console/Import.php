<?php namespace Ffte\Movies\Console;

use Exception;
use Ffte\Movies\Models\Category;
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

    protected $signature = 'movies:import {url=http://filmefuerdieerde.ch/api/movies}';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        //$url = $this->argument('url');
        $url = "C:\\Users\\munxar\\Downloads\\movies.json";
        $movies = json_decode(file_get_contents($url), true);
        $tags = [];
        $categories = [];

        foreach($movies as $movie) {
            $tags = array_merge($tags, $movie['tags']);
            array_push($categories, $movie['category']);
        }

        foreach($tags as $tag) {
            Tag::updateOrCreate(['id' => $tag['id']], [
                'name' => $tag['name'],
                'slug' => slugify($tag['name'])
            ]);
        }

        foreach($categories as $category) {
            $cat = Category::updateOrCreate(['id' => $category['id']], [
                'name' => $category['name'],
                'slug' => slugify($category['name'])
            ]);

            update($cat, $category, 'name');
            $cat->lang('en')->slug = slugify($category['name_en']);
            $cat->lang('fr')->slug = slugify($category['name_fr']);
            $cat->save();
        }

        foreach($movies as $movie) {
            $info = new Info($movie['technical_info']);

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
                'seo_keywords' => $movie['seo_keywords'],
                'updated_at' => $movie['updated_at'],
                'created_at' => $movie['created_at'],
                'year' => intval($info->get('Jahr')),
            ]);

            update($model, $movie, 'title');
            $model->slug = slugify($movie['title_en']);
            $model->slug = slugify($movie['title_fr']);
            update($model, $movie, 'subtitle');
            update($model, $movie, 'description');
            update($model, $movie, 'notes');
            update($model, $movie, 'jury_rating');
            update($model, $movie, 'other_rating');
            update($model, $movie, 'technical_info');
            update($model, $movie, 'links');
            update($model, $movie, 'seo_title');
            update($model, $movie, 'seo_description');
            update($model, $movie, 'seo_keywords');


            $model->tags = array_column($movie['tags'], 'id');
            $model->categories = array_column([$movie['category']], 'id');
            $model->formats = $movie['formats'];

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
                $medium->provider = convertProvider($m['provider']);
                $medium->movie = $model;
                $model->media()->add($medium);
            }

            $model->save();

            echo $model->id.' '.$model->title."\n";
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

function getFile($img) {
    $url = $img['name'];
    if(empty($url)) {
        return null;
    }
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
    $file->title = $img['title'];
    $file->description = $img['description_de'];

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

function update($model, $movie, $name) {
    $model->setAttributeTranslated($name, $movie[$name.'_en'], 'en');
    $model->setAttributeTranslated($name, $movie[$name.'_fr'], 'fr');
}

// string to provider entity
function convertProvider($name) {
    $data = [
        'Inactive' => NULL,
        'arte' => 1,
        'dailymotion' => 2,
        'distrify' => 3,
        'vhx' => 4,
        'vimeo' => 5,
        'youtube' => 6,
    ];
    return $data[$name];
}

class Info {
    private $values;
    public function __construct($info)
    {
        $lines = explode("\n", $info);
        $values = [];
        foreach($lines as $line) {
            $tokens = explode(":", $line);
            if(count($tokens) >= 2) {
                $values[$tokens[0]] = $tokens[1];
            }
        }
        $this->values = $values;
    }

    public function get($key) {
        return array_key_exists($key, $this->values) ? $this->values[$key] : null;
    }
}
