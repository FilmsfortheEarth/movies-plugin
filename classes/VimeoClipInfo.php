<?php

namespace Ffte\Movies\Classes;

class VimeoClipInfo implements ClipInfo
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
        //$data = json_decode(file_get_contents("https://vimeo.com/api/oembed.json?url={$this->url}"));

        return "https://player.vimeo.com/video/{$this->id}";
    }

    public function getProvider()
    {
        return 'Vimeo';
    }
}