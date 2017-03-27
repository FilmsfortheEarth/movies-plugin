<?php
/**
 * Created by PhpStorm.
 * User: saschaaeppli
 * Date: 27.03.17
 * Time: 14:31
 */

namespace Ffte\Movies\Classes;


class DistrifyClipInfoProvider implements ClipInfoProvider
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

        if(preg_match('@^https://distrify.com/videos/(.*)$@', $url, $matches)) {
            $clipInfo = new DistrifyClipInfo($matches[1]);
        }

        return $clipInfo;
    }
}