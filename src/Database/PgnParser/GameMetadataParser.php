<?php

namespace Chess\Database\PgnParser;
use Chess\Exception\PgnParserException;

abstract class GameMetadataParser extends AbstractInfoParser implements InfoParserInterface
{
    const SPACE_CHAR = ' ';

    const START_CHAR = '[';

    const END_CHAR = ']';

    abstract protected function getMetadataLabel(): string;

    /**
     * @return string
     */
    private function getExpectedLineStart(): string
    {
        return self::START_CHAR . $this->getMetadataLabel() . self::SPACE_CHAR;
    }

    protected function _support(string $char, string $lineWithChar): int
    {
        if ($this->isMaybe() && $lineWithChar === $this->getExpectedLineStart()) {
            return InfoParserResult::YES;
        } elseif ($this->isMaybe() && $char === self::SPACE_CHAR) {
            return InfoParserResult::NO;
        } elseif ($this->isMaybe()) {
            return InfoParserResult::MAYBE;
        }

        if ($this->isYes() && $char === self::END_CHAR) {
            return InfoParserResult::DONE;
        }

        if ($char === self::START_CHAR) {
            $this->clearCurrentLine();
            $this->addToCurrentLine($char);
            return InfoParserResult::MAYBE;
        }

        return $this->getCurrentState();
    }
}