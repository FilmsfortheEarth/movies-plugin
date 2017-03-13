<?php namespace Ffte\Movies\Models;

use October\Rain\Database\Model;
use \System\Models\File;

/**
 * Movie Model
 */
class Movie extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'title' => 'required',
        'slug' => 'required',
    ];

    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = [
        ['title', 'index' => true], ['slug', 'index' => true], 'subtitle', 'description', 'notes',
        'jury_rating', 'other_rating', 'technical_info', 'org_links',
        'seo_title', 'seo_description', 'seo_keywords'
    ];

    public $jsonable = [];

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
        //'media' => [Medium::class, 'delete' => true],
        'links' => [Link::class, 'delete' => true],
        'vod_services' => [VodService::class, 'delete' => true],
        'ratings' => [Rating::class, 'delete' => true],
    ];

    public $belongsTo = [];

    public $belongsToMany = [
        'categories' => [Category::class, 'table' => 'ffte_movies_category_movie'],
        'availabilities' => [Availability::class, 'table' => 'ffte_movies_availability_movie'],
        'people' => [Person::class, 'table' => 'ffte_movies_movie_person'],
        'countries' => [Country::class, 'table' => 'ffte_movies_movie_country'],
        //'languages' => [Language::class, 'table' => 'ffte_movies_movie_language'],
    ];

    public $morphTo = [];
    public $morphOne = [];

    public $morphToMany = [
        'tags' => [ Tag::class, 'name' => 'taggable', 'table' => 'ffte_movies_taggables'],
        'clips' => [ Clip::class, 'name' => 'clippable', 'table' => 'ffte_movies_clippables'],
        'languages' => [Language::class, 'name' => 'lang', 'table' => 'ffte_movies_languagable'],
        'subtitles' => [Language::class, 'name' => 'lang', 'table' => 'ffte_movies_languagable']
    ];

    public $attachOne = [
        'cover' => [File::class, 'delete' => true],
        'background' => [File::class, 'delete' => true],
    ];

    public $attachMany = [
        'images' => [File::class, 'delete' => true],
    ];

}