<?php

namespace Ffte\Movies\Classes;

use Db;

trait SaveTranslationHack
{
    public function afterSave()
    {
        if (post('RLTranslate')) {
            foreach (post('RLTranslate') as $locale => $value) {
                $data = json_encode($value);

                $obj = Db::table('rainlab_translate_attributes')
                    ->where('locale', $locale)
                    ->where('model_id', $this->getKey())
                    ->where('model_type', get_class($this));

                if ($obj->count() > 0) {
                    $obj->update(['attribute_data' => $data]);
                }
                else {
                    Db::table('rainlab_translate_attributes')->insert([
                        'locale' => $locale,
                        'model_id' => $this->getKey(),
                        'model_type' => get_class($this),
                        'attribute_data' => $data
                    ]);
                }
            }
        }

    }
}