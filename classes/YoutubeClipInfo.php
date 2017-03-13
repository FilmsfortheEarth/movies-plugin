<?php

namespace Ffte\Movies\Classes;


class YoutubeClipInfo implements ClipInfo
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * embed code for
     * @return string
     */
    public function getEmbedUrl()
    {
        return "https://www.youtube.com/embed/{$this->id}?rel=0&controls=1&showinfo=0";
    }

}