<?php

namespace Bits\Bits\Test;

use Bits\Bits\Reader;

class Text extends Reader {
    protected $text;

    protected function getFirstWordAttribute()
    {
        return explode(' ', $this->text)[0];
    }
};
