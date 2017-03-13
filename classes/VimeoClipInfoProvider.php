<?php

namespace Ffte\Movies\Classes;

class VimeoClipInfoProvider implements ClipInfoProvider
{

    /**
     * make clip info
     * @param $url
     * @return ClipInfo
     */
    public function makeClipInfo($url)
    {
        $clipInfo = null;
        $matches = [];

        if(preg_match('@^https://vimeo.com/(.*)$@', $url, $matches)) {
            $clipInfo = new VimeoClipInfo($matches[1]);
        }

        return $clipInfo;
    }
}