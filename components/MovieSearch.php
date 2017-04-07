<?php namespace Ffte\Movies\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Ffte\Movies\Classes\Link;
use Ffte\Movies\Models\Availability;
use \ffte\movies\models\Movie;
use Debugbar;
use Ffte\Movies\Models\Settings;
use Input;

class MovieSearch extends ComponentBase
{

    public function onRun()
    {
        $this->addJs('http://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js');
        $this->addJs('assets/vendor/js/vue.js');
        $this->addJs('assets/js/search.js');
    }

    public function onRender()
    {
        $this->page['applicationId'] = Settings::get('application_id');
        $this->page['searchApiKey'] = Settings::get('search_api_key');
    }

    public function componentDetails()
    {
        return [
            'name'        => 'Movie Search Component',
            'description' => 'Algolia Movie Search Component'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

}
