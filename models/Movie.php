<?php namespace Ffte\Movies\Models;

use October\Rain\Database\Model;

/**
 * Movie Model
 */
class Movie extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \Ffte\Search\Classes\SearchTrait;

    public function getSearchIndex($locale)
    {
        $this->translateContext($locale);

        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'categories' => implode(',', $this->categories->map(function($e) use($locale) { return $e->lang($locale)->name; })->toArray()),
            'tags' => implode(',', $this->tags->map(function($e) use($locale) { return $e->lang($locale)->name; })->toArray()),
            'search_tags' => $this->search_tags
        ];
    }

    public $rules = [
        'title' => 'required',
    ];

    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = [
        ['title', 'index' => true], 'subtitle', 'description', 'notes',
        'jury_rating', 'other_rating', 'technical_info', 'org_links',
        'seo_title', 'seo_description', 'seo_keywords', 'search_tags'
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
    public $hasOne = [
    ];
    public $hasMany = [
        'links' => [Link::class, 'delete' => true],
        'attachments' => [Attachment::class, 'delete' => true],
        'vod_services' => [VodService::class, 'delete' => true],
        'ratings' => [Rating::class, 'delete' => true],
        'rights' => [Right::class, 'delete' => true],
    ];

    public $belongsTo = [
        'ratio' => [Ratio::class]
    ];

    public $belongsToMany = [
        'categories' => [Category::class, 'table' => 'ffte_movies_category_movie'],
        'availabilities' => [Availability::class, 'table' => 'ffte_movies_availability_movie'],
        'directors' => [Person::class, 'table' => 'ffte_movies_movie_person_director'],
        'script' => [Person::class, 'table' => 'ffte_movies_movie_person_script'],
        'production' => [Person::class, 'table' => 'ffte_movies_movie_person_production'],
        'music' => [Person::class, 'table' => 'ffte_movies_movie_person_music'],
        'actors' => [Person::class, 'table' => 'ffte_movies_movie_person_actor'],

        'countries' => [Country::class, 'table' => 'ffte_movies_movie_country'],
        'shooting_locations' => [Country::class, 'table' => 'ffte_movies_movie_shooting_location'],

        'languages_audio' => [Language::class, 'table' => 'ffte_movies_movie_language_audio'],
        'languages_subtitle' => [Language::class, 'table' => 'ffte_movies_movie_language_subtitle'],
    ];

    public $morphTo = [];
    public $morphOne = [];

    public $morphToMany = [
        'tags' => [ Tag::class, 'name' => 'taggable', 'table' => 'ffte_movies_taggables'],
        'clips' => [ Clip::class, 'name' => 'clippable', 'table' => 'ffte_movies_clippables'],
    ];

    public $attachOne = [
        'cover' => [File::class, 'delete' => true],
        'background' => [File::class, 'delete' => true],
    ];

    public $attachMany = [
        'images' => [File::class, 'delete' => true],
    ];

}