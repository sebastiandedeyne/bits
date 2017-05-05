<?php

namespace BitsCms\Bits\Exceptions;

use Exception;

class BitNotFound extends Exception
{
    public static function withQuery($query)
    {
        return new self("No bit found for query `{$query}`");
    }
}
