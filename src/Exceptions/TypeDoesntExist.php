<?php

namespace BitsCms\Bits\Exceptions;

use Exception;

class TypeDoesntExist extends Exception
{
    public static function type($type)
    {
        return new self("Type `{$type}` doesn't exist");
    }
}
