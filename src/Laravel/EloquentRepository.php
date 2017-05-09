<?php

namespace Bits\Bits\Laravel;

use Bits\Bits\Bit;
use Bits\Bits\Laravel\Bit as Model;
use Bits\Bits\Repository;

class EloquentRepository implements Repository
{
    public function find(string $key)
    {
        return Model::where('key', $key)->first();
    }
}
