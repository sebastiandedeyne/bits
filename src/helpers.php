<?php

use Bits\Bits\Bit;

function bit($key)
{
    return Bit::read($key);
}
