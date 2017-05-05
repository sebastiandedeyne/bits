<?php

namespace BitsCms\Bits\Test;

use BitsCms\Bits\Bit;
use BitsCms\Bits\Exceptions\BitNotFound;
use BitsCms\Bits\Exceptions\TypeDoesntExist;
use BitsCms\Bits\Facades\Bit as BitFacade;

class BitTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->bit = Bit::create([
            'type' => 'text',
            'key' => 'hello_world',
            'value' => ['text' => 'Hello world'],
        ]);
    }

    public function test_it_can_find_a_bit_by_key()
    {
        $this->assertTrue(Bit::findByKey('hello_world')->is($this->bit));
    }

    public function test_it_can_find_a_bit_by_id()
    {
        $this->assertTrue(Bit::findById($this->bit->id)->is($this->bit));
    }

    public function test_it_can_return_a_reader_for_a_bit_by_key()
    {
        $reader = Bit::read('hello_world');

        $this->assertInstanceOf(Text::class, $reader);
        $this->assertEquals('Hello world', $reader->text);
    }

    public function test_it_can_return_a_reader_for_a_bit_by_id()
    {
        $reader = Bit::read($this->bit->id);

        $this->assertInstanceOf(Text::class, $reader);
        $this->assertEquals('Hello world', $reader->text);
    }

    public function test_read_throws_when_a_bit_wasnt_found()
    {
        $this->expectException(BitNotFound::class);
        Bit::read('foobar');
    }

    public function test_it_throws_when_theres_no_type_registered_for_the_bit()
    {
        $bit = Bit::create([
            'type' => 'page',
            'key' => 'home',
            'value' => [],
        ]);

        $this->expectException(TypeDoesntExist::class);
        Bit::read('home');
    }

    public function test_methods_can_be_called_via_the_facade()
    {
        $this->assertEquals('Hello world', BitFacade::read('hello_world')->text);
    }

    public function test_bits_can_be_read_via_the_helper_function()
    {
        $this->assertEquals('Hello world', bit('hello_world')->text);
    }
}
