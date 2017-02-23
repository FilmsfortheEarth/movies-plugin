<?php namespace Ffte\Movies\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use \ffte\movies\models\Movie;
use Debugbar;

class MovieSearch extends ComponentBase
{
    public $search = '';
    public $movies;

    public function onRun()
    {
        $this->search = $this->page['search'] = Input('search');

        $this->page['movieDetail'] = $this->property('movieDetail');
        $this->movies = $this->page['movies'] = $this->getMovies();
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

    public function getMovies() {
        $search = "%$this->search%";
        $page = trim(Input('page'));
        if (!strlen($page) || !preg_match('/^[0-9]+$/', $page)) {
            $page = 1;
        }

        return $this->page['movies'] = Movie::with('media', 'tags', 'categories', 'media.provider', 'cover', 'backgrounds')
            ->where('title', 'LIKE', $search)
            ->orWhere('description', 'LIKE', $search)
            ->orWhere('seo_title', 'LIKE', $search)
            ->orWhere('seo_description', 'LIKE', $search)
            ->orWhereHas('tags', function($q) use($search) {
                $q->where('name', 'LIKE', $search);
            })
            ->orWhereHas('categories', function($q) use($search) {
                $q->where('name', 'LIKE', $search);
            })
            ->paginate(30, $page);
    }

    /*
    public function onSearch() {
        $this->search = Input('search');

        return [
            '.movie-list' => $this->renderPartial('@movie-list')
        ];
    }
    */
}
