<?php

namespace Ffte\Movies\Classes;

class ClipInfoService
{
    /**
     * @var ClipInfoProvider[]
     */
    private $providers;

    public function __construct()
    {
        $this->providers = [
            new YoutubeClipInfoProvider(),
            new VimeoClipInfoProvider()
        ];
    }

    /**
     * @param $url string clip url
     * @return ClipInfo
     */
    public function getProvider($url)
    {
        $clipInfo = null;

        foreach($this->providers as $provider) {
            $clipInfo = $provider->makeClipInfo($url);
            if(null !== $clipInfo) {
                break;
            }
        }

        return $clipInfo;
    }

    /**
     * add a provider to this service
     * @param ClipInfoProvider $provider
     */
    public function registerProvider(ClipInfoProvider $provider)
    {
        array_push($this->providers, $provider);
    }
}