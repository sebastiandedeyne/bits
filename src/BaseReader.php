<?php

namespace Bits\Bits;

use Bits\Bits\Exceptions\AttributeDoesntExist;

abstract class BaseReader
{
    /**
     * Default implementation for loading a Bit's data in a new Reader instance.
     * 
     * @param array $data
     * 
     * @return \Bits\Bits\Reader
     */
    public static function load(array $data): Reader
    {
        $reader = new static();

        foreach ($data as $key => $value) {
            if (property_exists($reader, $key)) {
                $reader->$key = $value;
            }
        }

        return $reader;
    }

    /**
     * Retrieve a Reader property.
     *
     * - Retrieves protected and private fields for easy read-only attributes
     * - Retrieves computed properties implemented like Eloquent accessors
     *
     * @return mixed
     *
     * @throws \Bits\Bits\AttributeDoesntExist
     */
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
