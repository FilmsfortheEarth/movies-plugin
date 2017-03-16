<?php namespace Ffte\Movies;


use Backend;
use Exception;
use Ffte\Movies\Components\MovieDetail;
use Ffte\Movies\Components\MovieSearch;
use Ffte\Movies\Console\Import;
use Ffte\Movies\Models\Medium;
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
            'functions' => [
                'video_src' => function($medium) {
                    $url = $medium->provider ? $medium->provider->embed_url_video : '';

                    return App::make('twig')->render($url, ['code' => $medium->code]);
                },
                'image_src' => function($medium) {
                    $url = $medium->provider ? $medium->provider->embed_url_image : '';

                    return App::make('twig')->render($url, ['code' => $medium->code]);
                }
            ],
            'filters' => [
                'vimeo' => function($url) {
                    $store = Cache::store('file');

                    if (false === $store->has($url)) {
                        $vimeo_url = "https://placehold.it/350x150";

                        try {
                            $response = file_get_contents("https://vimeo.com/api/oembed.json?url=https://www.vimeo.com/$url&width=120&height=90");
                            $data = json_decode($response, true);
                            $vimeo_url = $data['thumbnail_url'];
                        } catch(Exception $exception) {

                        }
                        $store->forever($url, $vimeo_url);
                    }

                    return $store->get($url);
                }
            ]
        ];
    }

    public function registerListColumnTypes()
    {
        return [
            'languages' => function($value) {
                return implode(', ', array_map(function($language) { return $language['name']; }, $value->toArray()));
            }
        ];
    }
}
