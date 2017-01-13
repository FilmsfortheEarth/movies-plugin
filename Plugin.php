<?php namespace Ffte\Movies;

use Backend;
use System\Classes\PluginBase;

/**
 * Movies Plugin Information File
 */
class Plugin extends PluginBase
{

    
    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommand('ffte.import', 'Ffte\Movies\Console\Import');
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
