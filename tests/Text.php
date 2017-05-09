<?php

namespace Bits\Bits\Test;

use Bits\Bits\BaseReader;
use Bits\Bits\Reader;

class Text extends BaseReader implements Reader
{
    protected $text;

    protected function getFirstWordAttribute()
    {
        return explode(' ', $this->text)[0];
    }
};
