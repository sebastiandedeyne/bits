<?php

namespace Bits\Bits\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bits\Bits\Bit
 *
 * @method static \Bits\Bits\BitReader read($key)
 * @method static \Bits\Bits\Bit|null findByKey($key)
 * @method static \Bits\Bits\Bit|null findById($id)
 */
class Bit extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bits';
    }
}
