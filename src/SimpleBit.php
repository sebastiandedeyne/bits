<?php

namespace Bits\Bits;

class SimpleBit implements Bit
{
    /** @var string */
    private $type;
    
    /** @var array */
    private $data;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function data(): array
    {
        return $this->data;
    }
}
