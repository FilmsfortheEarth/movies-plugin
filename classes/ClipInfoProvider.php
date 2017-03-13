<?php

namespace Ffte\Movies\Classes;

/**
 * Interface EmbedCodeProvider
 * @package Ffte\Clips\Classes
 */
interface ClipInfoProvider
{
    /**
     * make clip info
     * @param $url
     * @return ClipInfo
     */
    public function makeClipInfo($url);
}
