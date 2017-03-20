<?php

namespace ffte\movies\classes;


class DefaultClipInfo implements ClipInfo
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
        return $this->id;
    }

    public function getProvider()
    {
        return "Unknown";
    }

    public function getThumbnailUrl()
    {
        return "http://placehold.it/120x90";
    }

}