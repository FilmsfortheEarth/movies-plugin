<?php namespace Ffte\Movies\Models;

use Model;

/**
 * Category Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = [
        'name'
    ];

    public $rules = [
        'name' => 'required'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_categories';

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
        'movies' => [
            Movie::class,
            'table' => 'ffte_movies_category_movie',
        ],
        'clips' => [Clip::class, 'table' => 'ffte_movies_category_clip']
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}
