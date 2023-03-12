<?php

namespace Chess\Tests\Unit\Database\Fake;
use Chess\Database\PgnParser\InfoParserInterface;
use Chess\Database\PgnParser\InfoParserResult;

class FakeInfoParser implements InfoParserInterface
{
    public function supports(string $char): int {
        return InfoParserResult::DONE;
    }

    public function setInfoOnPgnParser(\Chess\Database\PgnParserInterface $pgnParser): void
    {
        $pgnParser->setMovetext('1. d4');
    }
}
