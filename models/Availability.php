<?php namespace Ffte\Movies\Models;

use Model;

/**
 * Format Model
 */
class Availability extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_availabilities';

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
    public $belongsTo = [];
    public $belongsToMany = [
        'movies' => [Movie::class, 'table' => 'ffte_movies_availability_movie']
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
