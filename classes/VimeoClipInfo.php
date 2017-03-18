<?php

namespace Ffte\Movies\Classes;
use Debugbar;

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

    public function getThumbnailUrl()
    {
        $res = file_get_contents("https://vimeo.com/api/oembed.json?url=https://vimeo.com/{$this->id}");
        $data = json_decode($res, true);

        return $data['thumbnail_url'];
    }
}