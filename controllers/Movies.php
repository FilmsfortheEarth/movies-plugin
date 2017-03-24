<?php namespace Ffte\Movies\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\RelationController;
use Backend\Classes\Controller;
use Backend\Widgets\Form;
use BackendMenu;
use Debugbar;
use Ffte\Movies\Models\Movie;
use Ffte\Movies\Models\Rightsholder;

class Movies extends Controller
{
    public $requiredPermissions = ['ffte.movies.movies'];
    protected $rightsholderFormWidget;

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

        $this->rightsholderFormWidget = $this->createRightsholderFormWidget();
    }

    private function createRightsholderFormWidget()
    {
        $config = $this->makeConfig('$/ffte/movies/models/rightsholder/fields.yaml');
        $config->model = new Rightsholder();
        $widget = $this->makeFormWidget(Form::class, $config);
        $widget->bindToController();
        return $widget;
    }

    public function onLoadCreateRightsholder()
    {
        $this->vars['rightsholderFormWidget'] = $this->rightsholderFormWidget;
        return $this->makePartial('rightsholder_create_form');
    }

    public function onCreateRightsholder()
    {
        $data = $this->rightsholderFormWidget->getSaveData();
        $model = new Rightsholder();
        $model->fill($data);
        $model->save();

    }
}