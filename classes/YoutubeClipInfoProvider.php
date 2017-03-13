<?php

namespace Ffte\Movies\Classes;


class YoutubeClipInfoProvider implements ClipInfoProvider
{
    public function makeClipInfo($url)
    {
        $clipInfo = null;
        $matches = [];

        if(preg_match('@^https://www.youtube.com/watch\?v=(.*)$@', $url, $matches)) {
            $clipInfo = new YoutubeClipInfo($matches[1]);
        }


        return $clipInfo;
    }
}