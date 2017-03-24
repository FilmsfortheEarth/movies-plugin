<?php namespace Ffte\Movies\Models;

use Ffte\Movies\Classes\SaveTranslationHack;
use System\Models\File as SystemFile;
use Db;

/**
 * File Model
 */
class File extends SystemFile
{
    use SaveTranslationHack;

    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = [
        'title',
        'description'
    ];

}
