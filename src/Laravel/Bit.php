<?php

namespace Bits\Bits\Laravel;

use Bits\Bits\Bit as BitInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Bit extends Model implements BitInterface
{
    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    public function type(): string
    {
        return $this->type;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function getTable()
    {
        return Config::get('bits.table');
    }
}
