<?php namespace Ffte\Movies\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Media Back-end Controller
 */
class Media extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ffte.Movies', 'main-menu-item', 'side-menu-media');
    }
}
