<?php namespace Ffte\Movies\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * duration Form Widget
 */
class Duration extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'ffte_movies_duration';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('duration');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->convertToString();
        $this->vars['model'] = $this->model;
    }

    private function convertToString()
    {
        $value = $this->getLoadValue();
        if(null !== $value) {
            $seconds = intval($value);
            $hours = intdiv($seconds , 3600);
            $seconds -= $hours * 3600;

            $minutes = intdiv($seconds , 60);
            $seconds -= $minutes * 60;

            return "{$this->twoDigit($hours)}:{$this->twoDigit($minutes)}:{$this->twoDigit($seconds)}";
        } else {
            return $value;
        }
    }
    private function twoDigit($val)
    {
        return $val < 10 ? '0' . $val : "$val";
    }
    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/duration.css', 'ffte.movies');
        $this->addJs('js/jquery.maskedinput.min.js', 'ffte.movies');
        $this->addJs('js/duration.js', 'ffte.movies');
    }

    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        if(!empty($value)) {
            $array = explode(':', $value);
            $hours = intval($array[0]);
            $minutes = intval($array[1]);
            $seconds = intval($array[2]);
            return $hours * 3600 + $minutes * 60 + $seconds;
        } else {
            return null;
        }
    }
}
