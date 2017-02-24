<?php namespace Ffte\Movies\Classes;

use Input;

class Link
{
    public $title;
    public $url;
    public $isActive;

    public function __construct($title, $mode, $query, $current)
    {
        $query['mode'] = $mode;

        $this->title = $title;
        $this->url = '?'.http_build_query($query);
        $this->isActive = $mode == $current;
    }
}
