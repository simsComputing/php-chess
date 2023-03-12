<?php

namespace Chess\Database\PgnParser;

use Chess\Database\PgnParserInterface;

interface InfoParserInterface
{
    public function supports(string $char): int;

    public function setInfoOnPgnParser(PgnParserInterface $pgnParser): void;
}
