<?php

namespace Bits\Bits;

interface Bit
{
    public function type(): string;
    public function data(): array;
}
