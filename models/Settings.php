<?php
/**
 * Created by PhpStorm.
 * User: saschaaeppli
 * Date: 07.04.17
 * Time: 12:53
 */

namespace Ffte\Movies\Models;

use October\Rain\Database\Model;
use System\Behaviors\SettingsModel;

class Settings extends Model
{
    public $implement = [
        SettingsModel::class
    ];

    public $settingsCode = 'ffte_movies_settings';

    public $settingsFields = 'fields.yaml';
}