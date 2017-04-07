<?php namespace Ffte\Movies\Models;

use Ffte\Movies\Classes\SaveTranslationHack;
use October\Rain\Database\Model;
use October\Rain\Database\Traits\Validation;

/**
 * Model
 */
class Attachment extends Model
{
    use SaveTranslationHack;
    use Validation;

    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = ['title', 'url'];

    public $rules = [
        'url' => 'required'
    ];

    public $fillable = ['*'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_attachments';

    public $belongsTo = [
        'movie' => [Movie::class],
        'attachmenttype' => [AttachmentType::class]
    ];
}