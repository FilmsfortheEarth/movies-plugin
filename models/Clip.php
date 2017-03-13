<?php namespace Ffte\Movies\Models;

use Ffte\Movies\Classes\ClipInfoService;
use Model;
use RainLab\Translate\Behaviors\TranslatableModel;

/**
 * Clip Model
 */
class Clip extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = [
        TranslatableModel::class
    ];

    public $translatable = [
        'title'
    ];

    /*
     * Validation
     */
    public $rules = [
        'url' => 'required|url'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ffte_movies_clips';

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
    public $belongsTo = [
        'type' => [ClipType::class]
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public $morphToMany = [
        'tags' => [ Tag::class, 'name' => 'taggable', 'table' => 'ffte_movies_taggables'],
    ];

    public function getEmbedAttribute()
    {
        $service = new ClipInfoService;
        $info = $service->getProvider($this->url);
        if($info) {
            return $info->getEmbedUrl();
        }
        return null;
    }

}
