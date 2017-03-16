<?php namespace Ffte\Movies\Components;

use Cms\Classes\ComponentBase;
use Ffte\Movies\Models\Movie;
use Response;


class MovieDetail extends ComponentBase
{
    public $movie;
    public $medium;

    public function componentDetails()
    {
        return [
            'name'        => 'MovieDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'slug',
            ],
            'medium' => [
                'title' => 'medium',
            ],
        ];
    }

    public function onRun()
    {
        $slug = $this->property('slug');
        $movie = Movie::where('slug', '=', $slug)->first();

        if (null === $movie) {
            return $this->controller->run('404');
        }

        $medium_id = $this->property('medium');
        $media = $movie->clips()->where('id', '=', $medium_id)->first();

        if(null === $media)
        {
            $media = $movie->clips()->first();
        }

        $this->medium = $this->page['media'] = $media;
        $this->movie = $this->page['movie'] = $movie;
    }
}
