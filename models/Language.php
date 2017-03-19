<?php namespace Ffte\Movies\Models;

use Model;
use RainLab\Translate\Behaviors\TranslatableModel;

/**
 * Language Model
 */
class Language extends Model
{
    public $implement = [TranslatableModel::class];
    public $translatable = ['name'];
    public $timestamps = false;

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
    protected $fillable = ['name'];


}
