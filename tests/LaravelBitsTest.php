<?php

namespace Bits\Bits\Test;

use Bits\Bits\Bits;
use Bits\Bits\Exceptions\BitNotFound;
use Bits\Bits\Exceptions\TypeDoesntExist;
use Bits\Bits\Laravel\Bit;

class LaravelBitsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->bit = Bit::create([
            'type' => 'text',
            'key' => 'hello_world',
            'data' => ['text' => 'Hello world'],
        ]);

        $this->bits = $this->app->make(Bits::class);
    }

    public function test_it_can_read_a_bit()
    {
        $reader = $this->bits->read('hello_world');

        $this->assertInstanceOf(Text::class, $reader);
        $this->assertEquals('Hello world', $reader->text);
    }

    public function test_it_can_read_multiple_bits()
    {
        $readers = $this->bits->read(['hello_world', 'hello_world']);

        $this->assertEquals('Hello world', $readers[0]->text);
        $this->assertEquals('Hello world', $readers[1]->text);
    }

    public function test_read_throws_when_a_bit_wasnt_found()
    {
        $this->expectException(BitNotFound::class);
        $this->bits->read('foobar');
    }

    public function test_it_throws_when_theres_no_type_registered_for_the_bit()
    {
        $bit = Bit::create([
            'type' => 'page',
            'key' => 'home',
            'data' => [],
        ]);

        $this->expectException(TypeDoesntExist::class);
        $this->bits->read('home');
    }
}
