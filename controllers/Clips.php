<?php namespace Ffte\Movies\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Clips extends Controller
{
    public $requiredPermissions = ['ffte.movies.clips'];

    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ffte.Movies', 'main-menu-item', 'side-menu-clips');
    }
}