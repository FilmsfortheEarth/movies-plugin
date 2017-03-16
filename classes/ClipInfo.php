<?php

namespace Ffte\Movies\Classes;


interface ClipInfo
{
    /**
     * embed code for
     * @return string
     */
    public function getEmbedUrl();

    public function getProvider();
}