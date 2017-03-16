<?php namespace Ffte\Movies\Models;

use October\Rain\Database\Model;

/**
 * Ratio Model
 */
class Ratio extends Model
{
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_ratios';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * render ratio e.g. as 6:19, 3:4
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->width . ':' . $this->height;
    }

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
