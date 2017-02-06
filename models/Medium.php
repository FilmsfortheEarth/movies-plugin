<?php namespace Ffte\Movies\Models;

use Model;

/**
 * Medium Model
 */
class Medium extends Model
{
    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = ['title', 'url'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_media';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [

    ];
    public $hasMany = [

    ];
    public $belongsTo = [
        'movie' => [Movie::class]
    ];

    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
