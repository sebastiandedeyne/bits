<?php

namespace BitsCms\Bits\Exceptions;

use Exception;

class AttributeDoesntExist extends Exception
{
    public static function forCall($key, $type)
    {
        return new self("Attribute `{$key}` doesn't exist on type `{$type}`");
    }
}
