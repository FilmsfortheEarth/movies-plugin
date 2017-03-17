<?php namespace Ffte\Movies\Models;

use Model;

/**
 * Right Model
 */
class Right extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_rights';

    public $timestamps = false;

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
    public $hasOne = [

    ];
    public $hasMany = [];
    public $belongsTo = [
        'rightsholder' => [Rightsholder::class]
    ];
    public $belongsToMany = [
        'countries' => [Country::class, 'table' => 'ffte_movies_right_country']
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
