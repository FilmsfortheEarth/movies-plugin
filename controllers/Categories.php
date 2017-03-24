<?php namespace Ffte\Movies\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\RelationController;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Categories Back-end Controller
 */
class Categories extends Controller
{
    public $requiredPermissions = ['ffte.movies.categories'];

    public $implement = [
        FormController::class,
        'Backend.Behaviors.ListController',
        RelationController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ffte.Movies', 'main-menu-item', 'side-menu-categories');
    }
}
