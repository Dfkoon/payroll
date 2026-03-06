<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait Translatable
{
    /**
     * Get a translatable attribute.
     *
     * @param string $key
     * @return mixed
     */
    public function getTranslatedAttribute(string $key)
    {
        $locale = App::getLocale();
        $en_key = $key . '_en';

        if ($locale === 'en' && isset($this->$en_key) && !empty($this->$en_key)) {
            return $this->$en_key;
        }

        return $this->$key;
    }

    /**
     * Override toArray to include translated versions of specified fields
     */
    public function toArray()
    {
        $array = parent::toArray();
        $translatable = $this->translatable ?? [];

        foreach ($translatable as $field) {
            $array[$field] = $this->getTranslatedAttribute($field);
        }

        return $array;
    }
}
