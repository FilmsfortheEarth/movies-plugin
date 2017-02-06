<?php namespace Ffte\Movies\Models;

use Model;

/**
 * Tag Model
 */
class Tag extends Model
{
    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = ['name', 'slug'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_tags';

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
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];

    public $belongsToMany = [
        'movies' => [ Movie::class, 'table' => 'ffte_movies_movie_tag'],
    ];

    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}