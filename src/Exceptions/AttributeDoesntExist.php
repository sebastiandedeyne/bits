<?php

namespace Bits\Bits\Exceptions;

use Exception;

class AttributeDoesntExist extends Exception
{
    public static function forCall($key, Reader $reader)
    {
        return new self(
            sprintf("Attribute %s doesn't exist on reader `%s`", $key, get_class($reader))
        );
    }
}
