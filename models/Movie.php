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

    public $translatable = [
        'title', 'slug', 'subtitle', 'description', 'notes',
        'jury_rating', 'other_rating', 'technical_info', 'links',
        'seo_title', 'seo_description', 'seo_keywords'
    ];
    
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
        'tags' => [Tag::class, 'table' => 'ffte_movies_movie_tag'],
        'categories' => [Category::class, 'table' => 'ffte_movies_category_movie'],
    ];

    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];

    public $attachOne = [
        'cover' => [File::class, 'delete' => true]
    ];

    public $attachMany = [
        'backgrounds' => [File::class, 'delete' => true],
        'images' => [File::class, 'delete' => true]
    ];

}