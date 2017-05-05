<?php

use BitsCms\Bits\Bit;

function bit($key)
{
    return Bit::read($key);
}
