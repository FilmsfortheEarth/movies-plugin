<?php namespace Ffte\Movies\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class AttachmentTypes extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'ffte.movies.attachmenttypes' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Ffte.Movies', 'main-menu-item', 'side-menu-attachmenttypes');
    }
}