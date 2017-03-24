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
use October\Rain\Database\Traits\Validation;
use RainLab\Translate\Behaviors\TranslatableModel;

class CategoryMoviePivot extends Pivot
{
    use Validation;

    public $rules = [];
    use SaveTranslationHack;

    public $implement = [
        TranslatableModel::class
    ];
    public $translatable = ['pivot[description]'];

}