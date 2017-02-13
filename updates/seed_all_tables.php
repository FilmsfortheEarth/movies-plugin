<?php namespace Ffte\Movies\Updates;

use Ffte\Movies\Models\Country;
use Ffte\Movies\Models\Availability;
use Ffte\Movies\Models\Language;
use Ffte\Movies\Models\LinkType;
use Ffte\Movies\Models\MediaFormat;
use Ffte\Movies\Models\MediaProvider;
use October\Rain\Database\Updates\Seeder;
use October\Rain\Support\Facades\File;

class SeedAllTables extends Seeder {

    public function run()
    {
        $formats = [
            ['id' => 1, 'name' => 'VOD'],
            ['id' => 2, 'name' => 'Free Streaming'],
            ['id' => 3, 'name' => 'DVD'],
            ['id' => 4, 'name' => 'BluRay'],
            ['id' => 5, 'name' => 'Free Screenings']
        ];
        foreach($formats as $format) {
            Availability::create($format);
        }

        $mediaFormats = [
            ['id'=> 1, 'name' => 'Folge'],
            ['id'=> 2, 'name' => 'Reportage'],
            ['id'=> 3, 'name' => 'Kinofilm'],
            ['id'=> 4, 'name' => 'Lehrfilm'],
            ['id'=> 5, 'name' => 'Trailer'],
            ['id'=> 6, 'name' => 'Teaser'],
            ['id'=> 7, 'name' => 'Interview'],
            ['id'=> 8, 'name' => 'Vortrag'],
            ['id'=> 9, 'name' => 'Making Of'],
            ['id'=>10, 'name' => 'Virtual Reality Film'],
            ['id'=>11, 'name' => 'Andere'],
        ];

        foreach($mediaFormats as $mediaFormat) {
            MediaFormat::create($mediaFormat);
        }

        $providers = [
            ['id' => 1, 'name' => 'Arte Future'],
            ['id' => 2, 'name' => 'Dailymotion'],
            ['id' => 3, 'name' => 'Distrify'],
            ['id' => 4, 'name' => 'VHX'],
            ['id' => 5, 'name' => 'Vimeo'],
            ['id' => 6, 'name' => 'Youtube'],
        ];

        foreach($providers as $provider) {
           MediaProvider::create($provider);
        }

        $countries = [
            ['code' => 'de', 'name' => 'Deutschland'],
            ['code' => 'ch', 'name' => 'Schweiz'],
            ['code' => 'at', 'name' => 'Östereich'],
        ];

        foreach($countries as $country) {
            Country::create($country);
        }

        $languages = json_decode(File::get('plugins/ffte/movies/data/languages.json'), true);

        foreach($languages as $language) {
            Language::create([
                'code' => $language['code'],
                'name' => $language['name']
            ]);
        }

        $linkTypes = [
            [ 'id' => 1, 'name' => 'Andere' ],
            [ 'id' => 2, 'name' => 'Offizielle Website zum Film' ],
            [ 'name' => 'Facebook' ],
            [ 'name' => 'Twitter' ],
            [ 'name' => 'Vimeo' ],
            [ 'name' => 'Youtube' ],
            [ 'name' => 'Wikipedia' ],
            [ 'name' => 'Instagram' ],
        ];

        foreach($linkTypes as $linkType) {
            LinkType::create($linkType);
        }
    }
}