<?php namespace Ffte\Movies\Models;

use Model;

/**
 * Model
 */
class Rightsholder extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $timestamps = false;

    protected $fillable = ['name'];

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required',
        'url' => 'url'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_rightsholders';
}