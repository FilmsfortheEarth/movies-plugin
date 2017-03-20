<?php

namespace Ffte\Movies\Classes;


class DefaultClipInfoProvider implements ClipInfoProvider
{

    /**
     * make clip info
     * @param $url
     * @return ClipInfo
     */
    public function makeClipInfo($url)
    {
        return new DefaultClipInfo($url);
    }
}