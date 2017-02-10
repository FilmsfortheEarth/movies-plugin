<?php namespace Ffte\Movies\Controllers;

use Backend\Behaviors\FormController;
use Backend\Classes\Controller;
use BackendMenu;

class Movies extends Controller
{

    public $implement = [
        'Backend\Behaviors\ListController',
        FormController::class,
        'Backend\Behaviors\RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Ffte.Movies', 'main-menu-item', 'side-menu-movies');
    }

   
}