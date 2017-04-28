<?php namespace Ffte\Movies\Components;

use Cms\Classes\ComponentBase;
use Ffte\Movies\Models\Movie;
use Input;
use App;
use Request;
use DB;

class MovieSearch extends ComponentBase
{
    public $movies;

    public function onRun()
    {
        $this->page['query'] = $query = Request::query('query');
        $format = Request::query('format');

        $movies = Movie::with('tags', 'categories')->search($query)
            ->select(DB::raw('*, (stars_contents + stars_entertainment + stars_quality + stars_momentum + stars_craftsmanship) / 5 as rating'))
            ->orderBy('rating', 'DESC')
            ->orderBy('year', 'DESC')
            ->orderBy('title', 'ASC')
            ->paginate(20)
            ->appends(['query' => $query, 'format' => $format])
        ;

        $this->movies = $this->page['movies'] = $movies;

        if($format == 'json') {
            return $movies;
        }
    }

    public function onRender()
    {

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
