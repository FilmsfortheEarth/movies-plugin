<?php
/**
 * Created by PhpStorm.
 * User: munxar
 * Date: 20.03.2017
 * Time: 18:21
 */

namespace Ffte\Movies\Models;

use Ffte\Movies\Classes\SaveTranslationHack;
use October\Rain\Database\Pivot;

class CategoryMoviePivot extends Pivot
{
    /*
    use SaveTranslationHack;
    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];
    public $translatable = ['pivot[description]'];
    */

}