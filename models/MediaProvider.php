<?php namespace Ffte\Movies\Models;

use Model;

/**
 * MediaProvider Model
 */
class MediaProvider extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_media_providers';

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
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
