<?php namespace Ffte\Movies;


use Exception;
use Ffte\Movies\Components\MovieDetail;
use Ffte\Movies\Components\MovieSearch;
use Ffte\Movies\FormWidgets\Duration;
use Ffte\Movies\FormWidgets\MLFileUpload;
use System\Classes\PluginBase;
use App;
use Cache;
use \System\Twig\Extension as TwigExtension;

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
        $this->registerConsoleCommand('movies.import', 'Ffte\Movies\Console\Import');
        $this->registerConsoleCommand('movies.clear', 'Ffte\Movies\Console\Clear');

        $this->app->singleton('twig', function() {
            $twig = new \Twig_Environment(new \Twig_Loader_String());
            $twig->addExtension(new TwigExtension());
            return $twig;
        });
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
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
            }
        ];
    }

    public function registerFormWidgets()
    {
        return [
            Duration::class => 'duration',
            MLFileUpload::class => 'mlfileupload',
        ];
    }
}
