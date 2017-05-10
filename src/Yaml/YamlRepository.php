<?php

namespace Bits\Bits\Yaml;

use Bits\Bits\Repository;
use Bits\Bits\SimpleBit;
use Bits\Bits\Yaml\Exceptions\MissingType;
use Symfony\Component\Yaml\Parser;

class YamlRepository implements Repository
{
    public function __construct(string $source)
    {
        $yaml = new Parser();

        $this->source = $yaml->parse($source);
    }

    public function find(string $key)
    {
        $result = $this->source[$key] ?? null;

        return $result ?
            new SimpleBit(...$this->extractTypeAndData($result)) : null;
    }

    protected function extractTypeAndData(array $bit): array
    {
        $type = $bit['type'] ?? null;

        if (! $type) {
            throw new MissingType();
        }

        unset($bit['type']);

        return [$type, $bit];
    }
}
