<?php

namespace Chess\Tests\Unit\Eval;

use Chess\Board;
use Chess\Eval\SpaceEval;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Sicilian\Closed as ClosedSicilian;
use Chess\Tests\Sample\Opening\Sicilian\Open as OpenSicilian;

class SpaceEvalTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $spEval = (new SpaceEval(new Board()))->eval();

        $expected = [
            'w' => [
                'a3', 'b3', 'c3', 'd3', 'e3', 'f3', 'g3', 'h3',
            ],
            'b' => [
                'a6', 'b6', 'c6', 'd6', 'e6', 'f6', 'g6', 'h6',
            ],
        ];

        $this->assertSame($expected, $spEval);
    }

    /**
     * @test
     */
    public function open_sicilian()
    {
        $board = (new OpenSicilian(new Board()))->play();

        $spEval = (new SpaceEval($board))->eval();

        $expected = [
            'w' => [
                'a3', 'a4', 'a6', 'b1', 'b3', 'b5', 'c4', 'c6',
                'd2', 'd3', 'd5', 'e2', 'e3', 'e6', 'f3', 'f4',
                'f5', 'g1', 'g3', 'g4', 'g5', 'h3', 'h5', 'h6',
            ],
            'b' => [
                'a5', 'a6', 'b6', 'c5', 'c6', 'c7', 'd5', 'd7',
                'e5', 'e6', 'f5', 'g4', 'g6', 'g8', 'h3', 'h5',
                'h6',
            ],
        ];

        $this->assertSame($expected, $spEval);
    }

    /**
     * @test
     */
    public function closed_sicilian()
    {
        $board = (new ClosedSicilian(new Board()))->play();

        $spEval = (new SpaceEval($board))->eval();

        $expected = [
            'w' => [
                'a3', 'a4', 'b1', 'b3', 'b5', 'c4', 'd2', 'd5',
                'e2', 'e3', 'f1', 'f3', 'f4', 'f5', 'g4', 'g5',
                'h3', 'h4', 'h5', 'h6',
            ],
            'b' => [
                'a5', 'a6', 'b4', 'b6', 'b8', 'c7', 'd4', 'd7',
                'e5', 'e6', 'f5', 'f6', 'f8', 'g4', 'h3', 'h5',
                'h6',
            ],
        ];

        $this->assertSame($expected, $spEval);
    }
}