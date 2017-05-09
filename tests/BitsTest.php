<?php

namespace Bits\Bits\Test;

use Bits\Bits\Bit;
use Bits\Bits\Bits;
use Bits\Bits\Exceptions\BitNotFound;
use Bits\Bits\Exceptions\TypeDoesntExist;
use Bits\Bits\Repository;
use Bits\Bits\Test\Text;
use Mockery;
use PHPUnit\Framework\TestCase;

class BitsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->bit = Mockery::mock(Bit::class);
        $this->bit->shouldReceive('type')->andReturn('text');
        $this->bit->shouldReceive('data')->andReturn(['text' => 'Hello world']);

        $this->repository = Mockery::mock(Repository::class);

        $this->bits = new Bits($this->repository, ['text' => Text::class]);
    }

    public function test_it_can_read_a_bit()
    {
        $this->repository->shouldReceive('find')->with('hello_world')->andReturn($this->bit);

        $reader = $this->bits->read('hello_world');

        $this->assertInstanceOf(Text::class, $reader);
        $this->assertEquals('Hello world', $reader->text);
    }

    public function test_it_can_read_multiple_bits()
    {
        $this->repository->shouldReceive('find')->with('hello_world')->andReturn($this->bit);

        $readers = $this->bits->read(['hello_world', 'hello_world']);

        $this->assertEquals('Hello world', $readers[0]->text);
        $this->assertEquals('Hello world', $readers[1]->text);
    }

    public function test_read_throws_when_a_bit_wasnt_found()
    {
        $this->repository->shouldReceive('find')->with('foobar')->andReturn(null);

        $this->expectException(BitNotFound::class);
        $this->bits->read('foobar');
    }

    public function test_it_throws_when_theres_no_type_registered_for_the_bit()
    {
        $bit = Mockery::mock(Bit::class);
        $bit->shouldReceive('type')->andReturn('page');
        $bit->shouldReceive('data')->andReturn([]);

        $this->repository->shouldReceive('find')->with('home')->andReturn($bit);

        $this->expectException(TypeDoesntExist::class);
        $this->bits->read('home');
    }
}
