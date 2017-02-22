<?php namespace Ffte\Movies\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use \ffte\movies\models\Movie;
use Debugbar;

class MovieSearch extends ComponentBase
{
    public $search = '';

    public function onRun()
    {
        $this->page['movieDetail'] = $this->property('movieDetail');
        Debugbar::info('harr');
    }

    public function componentDetails()
    {
        return [
            'name'        => 'MovieSearch Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'movieDetail' => [
                'title' => 'Movie Detail Page',
                'type' => 'dropdown',
                'default' => 'movie'
            ]
        ];
    }

    /**
     * List of available CMS Pages as ooptions for movieDetail dropdown
     * @return mixed
     */
    public function getMovieDetailOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function movies() {
        return $this->page['movies'] = Movie::with('media', 'media.provider', 'cover', 'backgrounds')->where('title', 'LIKE', "%$this->search%")->get();
    }

    public function onSearch() {
        $this->search = Input('search');

        return [
            '.movie-list' => $this->renderPartial('@movie-list')
        ];
    }
}
