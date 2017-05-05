<?php

namespace BitsCms\Bits\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BitsCms\Bits\Bit
 *
 * @method static \BitsCms\Bits\Reader read($key)
 * @method static \BitsCms\Bits\Bit|null findByKey($key)
 * @method static \BitsCms\Bits\Bit|null findById($id)
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
