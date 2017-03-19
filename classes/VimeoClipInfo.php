<?php

namespace Ffte\Movies\Classes;
use Debugbar;
use Exception;

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
        return "https://player.vimeo.com/video/{$this->id}";
    }

    public function getProvider()
    {
        return 'Vimeo';
    }

    public function getThumbnailUrl()
    {
        try {
            $res = file_get_contents("https://vimeo.com/api/oembed.json?url=https://vimeo.com/{$this->id}");
            $data = json_decode($res, true);
            return $data['thumbnail_url'];
        } catch(Exception $exception) {
            return '';
        }
    }
}