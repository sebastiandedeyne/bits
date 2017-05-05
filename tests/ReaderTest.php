<?php

namespace BitsCms\Bits\Test;

use BitsCms\Bits\Exceptions\AttributeDoesntExist;
use BitsCms\Bits\Reader;
use Error;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->text = Text::load(['text' => 'Hello world']);
    }

    public function test_it_provides_read_only_properties()
    {
        $this->assertEquals('Hello world', $this->text->text);

        $this->expectException(Error::class);
        $this->text->text = 'Foo';
    }

    public function test_it_supports_accessors()
    {
        $this->assertEquals('Hello', $this->text->firstWord);
        $this->assertEquals('Hello', $this->text->first_word);
    }

    public function test_it_throws_when_a_property_is_retrieved_that_doesnt_exist()
    {
        $this->expectException(AttributeDoesntExist::class);
        $this->text->last_word;
    }
}
