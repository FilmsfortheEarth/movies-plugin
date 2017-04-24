<?php namespace Ffte\Movies\Components;

use Cms\Classes\ComponentBase;
use Ffte\Movies\Models\Movie;
use Input;
use Request;
use DB;

class MovieSearch extends ComponentBase
{


    function onRun()
    {
        $query = Request::query('query');
        $format = Request::query('format');

        $movies = Movie::addSelect(DB::raw('*, (stars_contents + stars_entertainment + stars_quality + stars_momentum + stars_craftsmanship) / 5 as rating'))
            ->where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orderBy('rating', 'DESC')
            ->orderBy('title', 'ASC')
            ->orderBy('year', 'DESC')
            ->paginate(20);

        $queryString = array_except(Input::query(), $movies->getPageName());
        $movies->appends($queryString);

        $this->page['query'] = $query;
        $this->page['movies'] = $movies;

        if($format == 'json') {
            return $movies;
        }
    }

    public function onSearch()
    {
        return [
            '.search-result' => 'hohoho'
        ];
    }

    public function componentDetails()
    {
        return [
            'name'        => 'Movie Search Component',
            'description' => 'Movie Search Component'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

}
