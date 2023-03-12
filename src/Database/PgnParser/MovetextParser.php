<?php

namespace Chess\Database\PgnParser;

use Chess\Database\PgnParserInterface;

class MovetextParser extends AbstractInfoParser
{
    const START_CHAR = '1';

    protected function _support(string $char, string $lineWithChar): int
    {
        if ($char === self::START_CHAR && $this->isStartOfLine()) {
            $this->clearCurrentLine();
            $this->addToCurrentLine($char);
            return InfoParserResult::MAYBE;
        }

        if ($this->isYes() && $this->hasRightEnding($lineWithChar)) {
            return InfoParserResult::DONE;
        }

        if ($this->isMaybe() && $this->startsWithFirstMove($lineWithChar)) {
            return InfoParserResult::YES;
        }

        return $this->getCurrentState();
    }

    private function startsWithFirstMove(string $lineWithChar): bool
    {
        $startStr = substr($lineWithChar, 0, 3);
        return $startStr === '1. ';
    }

    private function hasRightEnding(string $lineWithChar): bool
    {
        $explodedLine = explode(' ', $lineWithChar);
        $lastBlock = $explodedLine[count($explodedLine) - 1];
        if (in_array($lastBlock, ['1-0', '0-1', '*', '1/2-1/2'])) {
            return true;
        }
        return false;
    }

    protected function _setInfoOnPgnParser(PgnParserInterface $pgnParser): void
    {
        $pgnParser->setMovetext($this->getCurrentLine());
    }
}