<?php

namespace Chess\Database;

interface PgnParserInterface
{
    public function parse(): void;

    public function setEvent(string $event): void;

    public function setMovetext(string $text): void;

    public function getGames(): array;
}