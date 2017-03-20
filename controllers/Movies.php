<?php namespace Ffte\Movies\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\RelationController;
use Backend\Classes\Controller;
use BackendMenu;
use Debugbar;
use Ffte\Movies\Models\Movie;

class Movies extends Controller
{
    public $requiredPermissions = ['ffte.movies.movies'];

    public $implement = [
        'Backend\Behaviors\ListController',
        FormController::class,
        RelationController::class
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