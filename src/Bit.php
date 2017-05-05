<?php

namespace BitsCms\Bits;

use BitsCms\Bits\Exceptions\BitNotFound;
use BitsCms\Bits\Exceptions\TypeDoesntExist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Bit extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function read($key)
    {
        if (is_int($key)) {
            $bit = static::findById($key);
        } else {
            $bit = static::findByKey($key);
        }

        if (! $bit) {
            throw BitNotFound::withQuery($key);
        }

        return $bit->reader();
    }

    public static function findById($id)
    {
        return static::cache("bits:id:{$id}", function () use ($id) {
            return static::find($id);
        });
    }

    public static function findByKey($key)
    {
        return static::cache("bits:key:{$key}", function () use ($key) {
            return static::withKey($key)->first();
        });
    }

    protected static function cache($key, $data)
    {
        return Cache::driver(Config::get('bits.cache_driver'))->rememberForever($key, $data);
    }

    public function scopeWithKey($query, $key)
    {
        $query->where('key', $key);
    }

    public function reader()
    {
        $type = Config::get("bits.types.{$this->type}");

        if (! $type) {
            throw TypeDoesntExist::type($this->type);
        }

        return call_user_func([$type, 'load'], $this->value);
    }
}
