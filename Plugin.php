<?php namespace Ffte\Movies;


use AlgoliaSearch\Laravel\AlgoliaServiceProvider;
use Carbon\Carbon;
use Exception;
use Ffte\Movies\Components\MovieDetail;
use Ffte\Movies\Components\MovieSearch;
use Ffte\Movies\Console\Images;
use Ffte\Movies\FormWidgets\Duration;
use Ffte\Movies\FormWidgets\MLFileUpload;
use Ffte\Movies\FormWidgets\MLMediaFinder;
use System\Classes\PluginBase;
use App;
use Cache;
use Config;
//use \System\Twig\Extension as TwigExtension;


/**
 * Movies Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = [
        'RainLab.Translate'
    ];

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        //$this->registerConsoleCommand('movies.import', 'Ffte\Movies\Console\Import');
        //$this->registerConsoleCommand('movies.clear', 'Ffte\Movies\Console\Clear');
        $this->registerConsoleCommand('movies:images', Images::class);

        /*
        $this->app->singleton('twig', function() {
            $twig = new \Twig_Environment(new \Twig_Loader_String());
            $twig->addExtension(new TwigExtension());
            return $twig;
        });
        */
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        //App::register(AlgoliaServiceProvider::class);
        //Config::set('algolia.connections.main.id', 'MJO8ZVRUIE');
        //Config::set('algolia.connections.main.key', '3a9df9523992e77a07065c67506ba788');
    }

    public function registerComponents()
    {
        return [
            MovieSearch::class => 'movieSearch',
            MovieDetail::class => 'movieDetail',
        ];
    }

    public function registerMarkupTags()
    {
        return [
        ];
    }

    public function registerListColumnTypes()
    {
        return [
            'languages' => function($value) {
                $array = [];
                if($value !== null) {
                    $array = $value->toArray();
                }
                return implode(', ', array_map(function($language) { return $language['name']; }, $array));
            },
            'duration' => function($value) {
                $hours = floor($value / 3600);
                $mins = floor($value / 60 % 60);
                $secs = floor($value % 60);

                return $value ? sprintf('%02d:%02d:%02d', $hours, $mins, $secs) : '';
            }
        ];
    }

    public function registerFormWidgets()
    {
        return [
            Duration::class => 'duration',
            MLFileUpload::class => 'mlfileupload',
            MLMediaFinder::class => 'mlmediafinder',
        ];
    }
}
