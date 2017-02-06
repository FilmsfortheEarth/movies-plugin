<?php namespace Ffte\Movies\Models;

use Model;
use System\Models\File;

/**
 * Movie Model
 */
class Movie extends Model
{
    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = ['title', 'slug', 'subtitle'];
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_movies';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'media' => [Medium::class, 'delete' => true]
    ];

    public $belongsTo = [];

    public $belongsToMany = [
        'tags' => [Tag::class, 'table' => 'ffte_movies_movie_tag']
    ];

    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];

    public $attachOne = [
        'cover' => File::class
    ];

    public $attachMany = [
        'backgrounds' => File::class,
        'images' => File::class
    ];

}