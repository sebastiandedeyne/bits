<?php

namespace Bits\Bits\Laravel;

use Bits\Bits\Bit;
use Bits\Bits\Laravel\Bit as Model;
use Bits\Bits\Repository;
use Illuminate\Contracts\Cache\Repository as Cache;

class CacheRepository implements Repository
{
    /** @var \Bits\Bits\Repository */
    protected $repository;

    /** @var \Illuminate\Contracts\Cache\Repository */
    protected $cache;

    public function __construct(Repository $repository, Cache $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function find(string $key): Bit
    {
        return $this->cache->rememberForever("bits:key:{$key}", function () use ($key) {
            return $this->repository->find($key);
        });
    }
}
