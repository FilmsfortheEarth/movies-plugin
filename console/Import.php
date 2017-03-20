<?php namespace Ffte\Movies\Console;

use Exception;
use Ffte\Movies\Models\Clip;
use Ffte\Movies\Models\Category;
use Ffte\Movies\Models\Country;
use Ffte\Movies\Models\Language;
use Ffte\Movies\Models\Link;
use Ffte\Movies\Models\LinkType;
use Ffte\Movies\Models\Person;
use Ffte\Movies\Models\Tag;
use Illuminate\Console\Command;
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
        $base_path = base_path('data').DIRECTORY_SEPARATOR;

        $errors = [];
        // create cache dir if not existing
        if (!is_dir($base_path)) {
            mkdir($base_path, 0777);
        }

        $url = $this->argument('url');
        $moviesFile = $base_path.'movies.json';

        if(!file_exists($moviesFile)) {
            file_put_contents($moviesFile, file_get_contents($url));
        };

        $movies = json_decode(file_get_contents($moviesFile), true);
        $tags = [];
        $categories = [];

        foreach($movies as $movie) {
            $tags = array_merge($tags, $movie['tags']);
            array_push($categories, $movie['category']);
        }

        foreach($tags as $tag) {
            Tag::updateOrCreate(['id' => $tag['id']], [
                'name' => $tag['name']
            ]);
        }

        foreach($categories as $category) {
            $cat = Category::updateOrCreate(['id' => $category['id']], [
                'name' => $category['name']
            ]);

            update($cat, $category, 'name');
            $cat->save();
        }

        foreach($movies as $movie) {
            if(!preg_match('/Weitere/', $movie['title'])) {
                $info = new Info($movie['technical_info']);

                $model = Movie::updateOrCreate(['id' => $movie['id']], [
                    'id' => $movie['id'],
                    'title' => $movie['title'],
                    'original_title' => $info->getRegex('/Originaltitel:\s(.*)/m'),
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

                    'year' => $info->getInt('/Jahr:\s(\d+)/m'),
                    'duration' => $info->getInt('/Dauer:\s(\d+)/m') * 60,
                    'age_recommendation' => $info->getInt('/Alterszulassung:\s(\d+)/m'),

                    'stars_contents' => $movie['ratings'][0],
                    'stars_entertainment' => $movie['ratings'][1],
                    'stars_quality' => $movie['ratings'][2],
                    'stars_momentum' => $movie['ratings'][3],
                    'stars_craftsmanship' => $movie['ratings'][4],
                ]);

                update($model, $movie, 'title');
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

                $cover = getFile($movie['cover'], $base_path);
                if($cover != null) {
                    $model->cover = $cover;
                }

                $backgrounds = array_map(function($url) use($base_path) { return getFile($url, $base_path); }, $movie['backgrounds']);

                if(sizeof($backgrounds) > 0) {
                    $model->background()->add($backgrounds[0]);
                }

                $images = array_map(function($url) use($base_path) { return getFile($url, $base_path); }, $movie['images']);
                $model->images()->delete();
                foreach($images as $image) {
                    if($image != null) {
                        $model->images()->add($image);
                    }
                }

                $model->clips()->delete();

                foreach($movie['movies'] as $m) {
                    $clip = new Clip();
                    $clip->title = $m['title'];
                    $clip->url = getUrl($m['provider'], $m['url']);
                    $clip->save();
                    $model->clips()->add($clip);
                }

                $model->links()->delete();

                $error = getLinks($movie['links'], $model);
                array_push($errors, ['id' => $model->id, 'errors' => $error]);

                attachEntities(Person::class, $model, $info, 'Regie', 'directors');
                attachEntities(Person::class, $model, $info, 'Produktion', 'production');
                attachEntities(Person::class, $model, $info, 'Drehbuch', 'script');
                attachEntities(Person::class, $model, $info, 'Musik', 'music');
                attachEntities(Person::class, $model, $info, 'Akteure', 'actors');

                attachEntities(Country::class, $model, $info, 'Land', 'countries');
                attachEntities(Country::class, $model, $info, 'Drehorte', 'shooting_locations');

                attachEntities(Language::class, $model, $info, 'Sprache \(Audio\)', 'languages_audio');
                attachEntities(Language::class, $model, $info, 'Sprache \(Untertitel\)', 'languages_subtitle');


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

function attachEntities($clazz, $model, $info, $regexName, $name)
{
    $entities = $info->getArray($regexName);
    $res = [];
    foreach($entities as $entity) {
        // remove surrounding whitespaces
        $entity = trim($entity);
        $p = $clazz::updateOrCreate(['name' => $entity], ['name' => $entity]);
        array_push($res, $p->id);
    }
    $model->{$name}()->sync($res);
}

function getUrl($provider, $url)
{
    if($provider == 'youtube') {
        return "https://www.youtube.com/watch?v={$url}";
    }
    if($provider == 'vimeo') {
        return "https://vimeo.com/{$url}";
    }

    return "https://www.youtube.com/watch?v=NpEaa2P7qZI";
}

function getFile($img, $base_path) {

    $url = $img['name'];
    if(empty($url)) {
        return null;
    }
    $local_url = $base_path.$url;

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

class Info
{
    private $text;
    public function __construct($text)
    {
        // remove windows newline encoding to make preg_match with /m option happy.
        $this->text = str_replace("\r\n", "\n", $text);
    }

    public function getInt($regex)
    {
        $val = $this->getRegex($regex);
        return $val !== null ? intval($val) : null;
    }

    public function getRegex($regex, $default = null)
    {
        $match = [];
        $res = $default;
        if(preg_match($regex, $this->text, $match)) {
            $res = $match[1];
        }
        return $res;
    }

    public function getArray($name)
    {
        $regex = "/{$name}.*:\\s(.*)/m";
        $str = $this->getRegex($regex);
        $array = [];
        $str = str_replace('\r', '', $str);
        $str = str_replace('\n', '', $str);
        if(!empty($str)) {
            $array = explode(',', $str);
        }
        return $array;
    }
}

function getLinks($text, $movie) {
    $errors = [];
    // windows to unix newline
    $text = str_replace("\r\n", "\n", $text);
    // replace newline with |
    $data = str_replace("\n", "|", $text);
    // split by |
    $lines = explode("|", $data);
    $lines = array_filter($lines, function($v) { return !empty($v); });

    foreach($lines as $line) {
        $line = trim($line);
        $link = new Link();
        $link->movie = $movie;

        preg_match("/^.*<a.*href=\"?(.*)\"?.*>(.*)<\\/a>.*/is", $line, $matches);
        if(count($matches) == 3) {
            $link->url = $matches[1];
            $link->title = $matches[2];
        } else {
            if(preg_match('/^"(.*?)":\s?(https?.*)$/i', $line, $matches))
            {
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

