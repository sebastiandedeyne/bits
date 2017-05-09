<?php

namespace Bits\Bits\Exceptions;

use Exception;

class AttributeDoesntExist extends Exception
{
    public static function forCall($key, $reader)
    {
        return new self("Attribute {$key} doesn't exist on reader `{$reader}`");
    }
}
