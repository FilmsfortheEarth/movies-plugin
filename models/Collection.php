<?php namespace Ffte\Movies\Models;

use October\Rain\Database\Model;

/**
 * Model
 */
class Collection extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Validation
     */
    public $rules = [
        'title' => 'required'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_collections';

    public $belongsToMany = [
        'movies' => [
            Movie::class,
            'table' => 'ffte_movies_collection_movie',
            'pivot' => ['tip', 'description']
        ],
        'clips' => [
            Clip::class,
            'table' => 'ffte_movies_collection_clip',
            'pivot' => ['tip', 'description']
        ],
    ];
}