<?php

namespace BitsCms\Bits;

use BitsCms\Bits\Exceptions\AttributeDoesntExist;

abstract class Reader
{
    public static function load($data)
    {
        $reader = new static();

        foreach ($data as $key => $value) {
            if (property_exists($reader, $key)) {
                $reader->$key = $value;
            }
        }

        return $reader;
    }

    public function __get($key)
    {
        $accessor = 'get'.ucfirst(camel_case($key)).'Attribute';

        if (method_exists($this, $accessor)) {
            return $this->$accessor();
        }

        if (property_exists($this, $key)) {
            return $this->$key;
        }

        throw AttributeDoesntExist::forCall($key, static::class);
    }
}
