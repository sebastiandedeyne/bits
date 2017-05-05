<?php

namespace BitsCms\Bits\Test;

use BitsCms\Bits\Reader;

class Text extends Reader {
    protected $text;

    protected function getFirstWordAttribute()
    {
        return explode(' ', $this->text)[0];
    }
};
