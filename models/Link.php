<?php namespace Ffte\Movies\Models;

use Ffte\Movies\Classes\SaveTranslationHack;
use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Link Model
 */
class Link extends Model
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

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_links';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];

    public $belongsTo = [
        'movie' => [Movie::class],
        'linktype' => [LinkType::class],
    ];

    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
