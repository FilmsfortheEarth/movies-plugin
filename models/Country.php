<?php namespace Ffte\Movies\Models;

use Model;
use RainLab\Translate\Behaviors\TranslatableModel;

/**
 * Country Model
 */
class Country extends Model
{
    public $implement = [TranslatableModel::class];
    public $translatable = ['name'];
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_countries';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name'];

    public function getNameEnAttribute()
    {
        return $this->noFallbackLocale()->lang('en')->name;
    }

    public function getNameFrAttribute()
    {
        return $this->noFallbackLocale()->lang('fr')->name;
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
