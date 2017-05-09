<?php

namespace Bits\Bits;

use Bits\Bits\Exceptions\BitNotFound;
use Bits\Bits\Exceptions\TypeDoesntExist;

class Bits
{
    /** @var \Bits\Bits\Repository */
    protected $repository;

    /** @var array */
    protected $readers;

    public function __construct(Repository $repository, array $readers)
    {
        $this->repository = $repository;
        $this->readers = $readers;
    }

    /**
     * Retrieves a Bit by key and returns it's Reader instance.
     *
     * - If `$key` is a string, it retrieves by key
     * - If `$key` is an array, it will retrieve multiple Bits by key
     * 
     * @param string|array $key
     * 
     * @return \Bits\Bits\Reader|\Bits\Bits\BitReader[]
     *
     * @throws \Bits\Bits\Exceptions\BitNotFound
     * @throws \Bits\Bits\Exceptions\TypeDoesntExist
     */
    public function read($key)
    {
        if (is_array($key)) {
            return array_map([$this, 'read'], $key);
        }

        $bit = $this->repository->find($key);

        if (! $bit) {
            throw BitNotFound::withKey($key);
        }

        $reader = $this->readers[$bit->type()] ?? null;

        if (is_null($reader) || ! class_exists($reader)) {
            throw TypeDoesntExist::type($bit->type());
        }

        return $reader::load($bit->data());
    }
}
