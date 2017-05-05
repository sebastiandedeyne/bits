<?php

namespace Bits\Bits;

use Bits\Bits\Exceptions\BitNotFound;
use Bits\Bits\Exceptions\TypeDoesntExist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

class Bit extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Retrieves a Bit by it's key or id, and returns it's BitReader instance.
     *
     * - If `$key` is a string, it retrieves by key
     * - If `$key` is an int, it retrieves by id
     * - If `$key` is an array, it will retrieve multiple Bits by key or id, 
     *   depending on the array's contents
     * 
     * @param string|int|array $key
     * 
     * @return \Bits\Bits\BitReader|\Bits\Bits\BitReader[]
     *
     * @throws \Bits\Bits\BitNotFound
     * @throws \InvalidArgumentException
     */
    public static function read($key)
    {
        if (is_array($key)) {
            return array_map([static::class, 'read'], $key);
        }

        if (is_int($key)) {
            $bit = static::findById($key);
        } elseif(is_string($key)) {
            $bit = static::findByKey($key);
        } else {
            throw new InvalidArgumentException('`$key` must be a string, int or array');
        }

        if (! $bit) {
            throw BitNotFound::withQuery($key);
        }

        return $bit->reader();
    }

    /**
     * Find a Bit by id.
     * 
     * Retrieves from a cache with the static `cache` method.
     *
     * @param int $id
     * 
     * @return \Bits\Bits\Bit|null
     */
    public static function findById($id)
    {
        return static::cache("id:{$id}", function () use ($id) {
            return static::find($id);
        });
    }

    /**
     * Find a Bit by key.
     * 
     * Retrieves from a cache with the static `cache` method.
     *
     * @param string $key
     * 
     * @return \Bits\Bits\Bit|null
     */
    public static function findByKey($key)
    {
        return static::cache("key:{$key}", function () use ($key) {
            return static::withKey($key)->first();
        });
    }

    /**
     * Cache data for a Bit forever.
     * 
     * @param string $key
     * @param mixed $data
     * 
     * @return mixed
     */
    protected static function cache($key, $data)
    {
        $cache = Cache::driver(Config::get('bits.cache_driver'));

        return $cache->rememberForever("bits:{$key}", $data);
    }

    /**
     * Scope a Bit query by key.
     * 
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $key
     */
    public function scopeWithKey($query, $key)
    {
        $query->where('key', $key);
    }

    /**
     * Return the reader instance for the Bit. BitReaders are registered
     * int the `bits` configuration.
     *
     * @return \Bits\Bits\BitReader
     *
     * @throws \Bits\Bits\Exceptions\TypeDoesntExist
     */
    public function reader()
    {
        $type = Config::get("bits.types.{$this->type}");

        if (! $type) {
            throw TypeDoesntExist::type($this->type);
        }

        return call_user_func([$type, 'load'], $this->data);
    }
}
