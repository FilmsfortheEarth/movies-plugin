<?php namespace Ffte\Movies\Models;

use Model;
use RainLab\Translate\Behaviors\TranslatableModel;

/**
 * VodService Model
 */
class VodService extends Model
{
    public $implement = [
        TranslatableModel::class
    ];

    public $translatable = [
        'url'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_vod_services';

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
        'vod_provider' => [VodProvider::class]
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
