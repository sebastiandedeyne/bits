<?php

namespace Bits\Bits\Exceptions;

use Exception;

class BitNotFound extends Exception
{
    public static function withKey($key)
    {
        return new self("No bit found with key `{$key}`");
    }
}
