<?php

namespace Chess\Tests\Unit\Variant\Capablanca100\PGN\AN;

use Chess\Exception\UnknownNotationException;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Variant\Capablanca100\PGN\AN\Square;

class SquareTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function integer_throws_exception()
    {
        $this->expectException(UnknownNotationException::class);

        Square::validate(9);
    }

    /**
     * @test
     */
    public function float_throws_exception()
    {
        $this->expectException(UnknownNotationException::class);

        Square::validate(9.75);
    }

    /**
     * @test
     */
    public function foo_throws_exception()
    {
        $this->expectException(UnknownNotationException::class);

        Square::validate('foo');
    }

    /**
     * @test
     */
    public function k1_throws_exception()
    {
        $this->expectException(UnknownNotationException::class);

        Square::validate('k1');
    }

    /**
     * @test
     */
    public function a9()
    {
        $this->assertSame(Square::validate('a9'), 'a9');
    }

    /**
     * @test
     */
    public function j1()
    {
        $this->assertSame(Square::validate('j1'), 'j1');
    }

    /**
     * @test
     */
    public function a1()
    {
        $this->assertSame(Square::validate('a1'), 'a1');
    }

    /**
     * @test
     */
    public function a10()
    {
        $this->assertSame(Square::validate('a10'), 'a10');
    }

    /**
     * @test
     */
    public function color_a1()
    {
        $this->assertSame(Square::color('a1'), 'b');
    }

    /**
     * @test
     */
    public function color_j10()
    {
        $this->assertSame(Square::color('j10'), 'b');
    }
}
