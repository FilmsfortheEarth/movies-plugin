<?php namespace Ffte\Movies\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Link Model
 */
class Link extends Model
{
    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = ['title', 'url'];

    use Validation;

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
