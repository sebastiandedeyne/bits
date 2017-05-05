<?php

namespace Bits\Bits\Test;

use Bits\Bits\BitReader;

class Text extends BitReader {
    protected $text;

    protected function getFirstWordAttribute()
    {
        return explode(' ', $this->text)[0];
    }
};
