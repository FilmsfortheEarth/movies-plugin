<?php namespace Ffte\Movies\Models;

use Model;
use RainLab\Translate\Behaviors\TranslatableModel;

/**
 * Model
 */
class AttachmentType extends Model
{
    use \October\Rain\Database\Traits\Validation;
    public $implement = [
        TranslatableModel::class
    ];
    public $translatable = ['name'];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_attachment_types';
}