<?php

namespace Ffte\Movies\Classes;

use Db;

trait SaveTranslationHack
{
    public function afterSave()
    {
        if (post("RLTranslate")) {
            foreach (post("RLTranslate") as $key => $value) {

                $data = json_encode($value);

                $obj = Db::table("rainlab_translate_attributes")
                    ->where("locale", $key)
                    ->where("model_id", $this->id)
                    ->where("model_type", get_class($this->model));

                if ($obj->count() > 0) {
                    $obj->update(["attribute_data" => $data]);
                }

            }
        }
    }
}