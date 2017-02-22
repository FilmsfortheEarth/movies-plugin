<?php namespace Ffte\Movies\Console;

use Exception;
use Ffte\Movies\Models\Category;
use Ffte\Movies\Models\Link;
use Ffte\Movies\Models\LinkType;
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
        $errors = [];

        $url = $this->argument('url');
        //$url = "C:\\Users\\munxar\\Downloads\\movies.json";
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
            if(!preg_match('/Weitere/', $movie['title'])) {
                $info = new Info($movie['technical_info']);

                $model = Movie::updateOrCreate(['id' => $movie['id']], [
                    'id' => $movie['id'],
                    'title' => $movie['title'],
                    'slug' => slugify($movie['title']).'-'.$movie['id'],
                    'subtitle' => $movie['subtitle'],
                    'description' => $movie['description'],
                    'notes' => $movie['notes'],
                    'jury_rating' => $movie['jury_rating'],
                    'other_rating' => $movie['other_rating'],
                    'technical_info' => $movie['technical_info'],
                    'org_links' => $movie['links'],
                    'seo_title' => $movie['seo_title'],
                    'seo_description' => $movie['seo_description'],
                    'seo_keywords' => $movie['seo_keywords'],
                    'updated_at' => $movie['updated_at'],
                    'created_at' => $movie['created_at'],
                    'year' => $info->getInt('Jahr'),
                    'duration' => $info->get('Dauer'),

                    'stars_contents' => $movie['ratings'][0],
                    'stars_entertainment' => $movie['ratings'][1],
                    'stars_quality' => $movie['ratings'][2],
                    'stars_momentum' => $movie['ratings'][3],
                    'stars_craftsmanship' => $movie['ratings'][4],

                ]);

                update($model, $movie, 'title');
                $model->lang('en')->slug = slugify($movie['title_en']).'-'.$movie['id'];
                $model->lang('fr')->slug = slugify($movie['title_fr']).'-'.$movie['id'];
                update($model, $movie, 'subtitle');
                update($model, $movie, 'description');
                update($model, $movie, 'notes');
                update($model, $movie, 'jury_rating');
                update($model, $movie, 'other_rating');
                update($model, $movie, 'technical_info');

                update($model, $movie, 'seo_title');
                update($model, $movie, 'seo_description');
                update($model, $movie, 'seo_keywords');

                $model->lang('en')->org_links = $movie['links_en'];
                $model->lang('fr')->org_links = $movie['links_fr'];

                $model->tags = array_column($movie['tags'], 'id');
                $model->categories = array_column([$movie['category']], 'id');
                $model->availabilities = $movie['formats'];

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
                    $medium->code = $m['url'];
                    $medium->provider = convertProvider($m['provider']);
                    $medium->movie = $model;
                    $model->media()->add($medium);
                }

                $model->links()->delete();

                $error = getLinks($movie['links'], $model);
                array_push($errors, ['id' => $model->id, 'errors' => $error]);

                $model->save();

                echo $model->id.' '.$model->title."\n";
            } else {
                echo $movie['id']." skipped\n";
            }
        }

        file_put_contents('errors.json', json_encode($errors, JSON_PRETTY_PRINT));
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

    public function getInt($key) {
        $val = $this->get($key);
        return $val != null ? intval($val) : $val;
    }
}

function getLinks($text, $movie) {
    $errors = [];
    // replace newline with |
    $data = str_replace("\r\n", "|", $text);
    // split by |
    $lines = explode("|", $data);
    $lines = array_filter($lines, function($v) { return !empty($v); });

    foreach($lines as $line) {
        $link = new Link();
        $link->movie = $movie;

        preg_match("/^.*<a.*href=\"?(.*)\"?.*>(.*)<\\/a>.*/is", $line, $matches);
        if(count($matches) == 3) {
            $link->url = $matches[1];
            $link->title = $matches[2];
        } else {
            preg_match("/^.*\\\"(.*)\\\" *: *(.*)$/is", $line, $matches);
            if(count($matches) == 3) {
                $link->title = $matches[1];
                $link->url = $matches[2];
            }
        }
        if($link != "") {
            $type = LinkType::where('name', '=', $link->title)->first();
            if($type == null) {
                $type = 1;
            }
        } else {
            $type = 1;
        }

        $link->linktype = $type;

        try {
            $link->save();
        } catch(Exception $e) {
            array_push($errors, ['error' => $e->getMessage()]);
            //echo "# ERROR: " . $movie->id . "\n" . $line . "\n" . $link->url . ", " . $link->title . "\n";
        }
    };

    return $errors;
}

