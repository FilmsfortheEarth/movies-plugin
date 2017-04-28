<?php namespace Ffte\Movies;

use Ffte\Movies\Components\MovieDetail;
use Ffte\Movies\Components\MovieSearch;
use Ffte\Movies\Console\Images;
use Ffte\Movies\Console\Reindex;
use Ffte\Movies\Console\TranslateImages;
use Ffte\Movies\FormWidgets\Duration;
use Ffte\Movies\FormWidgets\MLFileUpload;
use Ffte\Movies\FormWidgets\MLMediaFinder;
use Ffte\Movies\Models\Settings;
use System\Classes\PluginBase;
use App;
use Cache;
use Config;


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
        $this->registerConsoleCommand('movies:images', Images::class);
        $this->registerConsoleCommand('movies:reindex', Reindex::class);
        $this->registerConsoleCommand('movies:trans', TranslateImages::class);
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

    public function registerPageSnippets()
    {
        return [
            MovieSearch::class => 'movieSearch',
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

    public function registerSettings()
    {
        return [

        ];
    }
}
