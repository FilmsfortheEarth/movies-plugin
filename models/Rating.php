<?php namespace Ffte\Movies\Models;

use Ffte\Movies\Classes\SaveTranslationHack;
use Model;

/**
 * Rating Model
 */
class Rating extends Model
{
    /**
     * todo: remove if https://github.com/rainlab/translate-plugin/issues/209 is fixed
     */
    use SaveTranslationHack;

    public $implement = [
        'RainLab.Translate.Behaviors.TranslatableModel'
    ];

    public $translatable = [
        'content'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_ratings';

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
        'rating_type' => [RatingType::class]
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


}
