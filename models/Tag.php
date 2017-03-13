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

    public $translatable = ['name'];

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

    public $morphedByMany = [
        'movies' => [ Movie::class, 'name' => 'taggable', 'table' => 'ffte_movies_taggables'],
        'clips' => [ Clip::class, 'name' => 'taggable', 'table' => 'ffte_movies_taggables'],
    ];

}