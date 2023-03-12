<?php

namespace Chess\Database\PgnParser;

use Chess\Database\PgnParserInterface;

class EventParser extends GameMetadataParser
{
    const EXPECTED_LINE_START = '[Event ';

    protected function getMetadataLabel(): string
    {
        return 'Event';
    }

    protected function _setInfoOnPgnParser(PgnParserInterface $pgnParser): void
    {
        $matches = [];
        preg_match('/\[Event "(.+)"\]/', $this->getCurrentLine(), $matches);
        $event = $matches[1];
        $pgnParser->setEvent($event);
    }
}