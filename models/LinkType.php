<?php namespace Ffte\Movies\Models;

use Model;

/**
 * LinkType Model
 */
class LinkType extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_link_types';

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
