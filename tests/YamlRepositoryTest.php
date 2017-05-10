<?php

namespace Bits\Bits\Test;

use Bits\Bits\Yaml\Exceptions\MissingType;
use Bits\Bits\Yaml\YamlRepository;
use PHPUnit\Framework\TestCase;

class YamlRepositoryTest extends TestCase
{
    /** @var \Bits\Bits\Yaml\YamlRepository */
    private $repository;

    public function setUp()
    {
        $this->repository = new YamlRepository(
            file_get_contents(__DIR__.'/fixtures/bits.yml')
        );
    }

    public function test_it_can_retrieve_a_bit_from_a_yaml_file()
    {
        $bit = $this->repository->find('hello_world');

        $this->assertEquals('text', $bit->type());
        $this->assertEquals(['text' => 'Hello world'], $bit->data());
    }

    public function test_it_returns_null_when_no_bit_was_found()
    {
        $this->assertNull($this->repository->find('foobar'));
    }

    public function test_it_throws_when_theres_no_type_specified()
    {
        $this->expectException(MissingType::class);
        $this->repository->find('no_type');
    }
}
