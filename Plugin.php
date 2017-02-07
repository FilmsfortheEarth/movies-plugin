<?php namespace Ffte\Movies;

use Backend;
use System\Classes\PluginBase;

/**
 * Movies Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = [
        'RainLab.Translate'
    ];

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommand('ffte.import', 'Ffte\Movies\Console\Import');
        $this->registerConsoleCommand('ffte.clear', 'Ffte\Movies\Console\Clear');
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
    }
}
