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

    public function getNameEnAttribute()
    {
        return $this->noFallbackLocale()->lang('en')->name;
    }

    public function getNameFrAttribute()
    {
        return $this->noFallbackLocale()->lang('fr')->name;
    }

    public $belongsToMany = [
        'movies_audio' => [Movie::class, 'table' => 'ffte_movies_movie_language_audio'],
        'movies_subtitle' => [Movie::class, 'table' => 'ffte_movies_movie_language_subtitle'],
        'clips_audio' => [Language::class, 'table' => 'ffte_movies_clip_language_audio'],
        'clips_subtitle' => [Language::class, 'table' => 'ffte_movies_clip_language_subtitle'],
    ];

    public $morphToMany = [

    ];

}
