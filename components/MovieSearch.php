<?php namespace Ffte\Movies\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Ffte\Movies\Classes\Link;
use Ffte\Movies\Models\Availability;
use \ffte\movies\models\Movie;
use Debugbar;
use Input;

class MovieSearch extends ComponentBase
{
    public $search = '';
    public $movies;
    public $availabilities;
    public $availability_id;
    public $sorts;
    public $sort;
    public $sort_dir;

    public function onRun()
    {
        $query = Input::all();
        $mode = Input('mode');
        if(empty($mode)) {
            $mode = 'list';
        }
        $this->page['mode'] = $mode;
        $this->page['modes'] = [new Link('fa fa-list', 'list', $query, $mode), new Link('fa fa-th', 'cover', $query, $mode)];

        $this->availabilities =  $this->page['availabilities'] = Availability::orderBy('name')->get();
        $this->sorts = $this->page['sorts'] = ['year' => 'Release Year', 'title' => 'Title'];

        $this->availability_id = $this->page['availability_id'] = Input('availability');
        $this->search = $this->page['search'] = Input('search');
        $this->sort = $this->page['sort'] = Input('sort');
        $this->sort_dir = $this->page['sort_dir'] = Input('sort_dir');

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
        $availabilty_id = $this->availability_id;

        $sort = $this->sort;

        if(empty($sort)) {
            $sort = 'year';
        }

        return $this->page['movies'] = Movie::with('clips', 'tags', 'categories', 'cover', 'background')
            ->whereHas('availabilities', function($q) use($availabilty_id) {
                if(!empty($availabilty_id)) {
                    $q->where('id', $availabilty_id);
                }
            })
            ->where(function($q) use($search) {
                $q->where('title', 'LIKE', $search)
                    ->orWhere('description', 'LIKE', $search)
                    ->orWhere('seo_title', 'LIKE', $search)
                    ->orWhere('seo_description', 'LIKE', $search)
                    ->orWhereHas('tags', function($q) use($search) {
                        $q->where('name', 'LIKE', $search);
                    })
                    ->orWhereHas('categories', function($q) use($search) {
                        $q->where('name', 'LIKE', $search);
                    });
            })
            ->orderBy($sort, $this->sort_dir)
            ->paginate(30, $page);
    }

}
