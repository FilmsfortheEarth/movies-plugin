<?php namespace Ffte\Movies\Updates;

use Ffte\Movies\Models\AttachmentType;
use October\Rain\Database\Updates\Seeder;

class SeedAttachmentTypes extends Seeder {

    public function run()
    {
        $types = [
            [ 'name' => 'Filmheft' ],
            [ 'name' => 'Presseheft' ],
            [ 'name' => 'Schulunterlagen' ],
            [ 'name' => 'Andere' ]
        ];

        foreach($types as $type) {
            AttachmentType::create($type);
        }

    }
}