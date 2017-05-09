<?php

namespace Bits\Bits;

interface Repository
{
    public function find(string $key): Bit;
}
