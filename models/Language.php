<?php namespace Ffte\Movies\Models;

use Model;

/**
 * Language Model
 */
class Language extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_languages';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['code', 'name'];

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
