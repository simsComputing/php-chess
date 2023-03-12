<?php

namespace Chess\Database\PgnParser;

use Chess\Database\PgnParserInterface;

abstract class AbstractInfoParser implements InfoParserInterface
{
    private ?string $currentLine = null;

    private int $currentState = InfoParserResult::NO;

    private bool $startOfLine = true;

    public function supports(string $char): int
    {
        if ($char === PHP_EOL) {
            $result = $this->supports(' ');
            $this->startOfLine = true;
            return $result;
        }
        $this->addToCurrentLine($char);
        $state = $this->_support($char, $this->getCurrentLine());
        $this->setCurrentState($state);
        $this->startOfLine = false;
        return $state;
    }

    abstract protected function _support(string $char, string $lineWithChar): int;

    /**
     * @param string $char
     * @return void
     */
    protected function addToCurrentLine(string $char): void
    {
        if ($this->currentLine === null) {
            $this->currentLine = '';
        }

        $this->currentLine .= $char;
    }

    protected function clearCurrentLine(): void
    {
        $this->currentLine = null;
    }

    /**
     * Get the value of currentLine
     */ 
    public function getCurrentLine(): ?string
    {
        return $this->currentLine;
    }

    /**
     * Get the value of currentState
     */ 
    public function getCurrentState(): int
    {
        return $this->currentState;
    }

    /**
     * @param integer $currentState
     * @return void
     */
    public function setCurrentState(int $currentState)
    {
        $this->currentState = $currentState;

        return $this;
    }

    public function setInfoOnPgnParser(PgnParserInterface $pgnParser): void
    {
        $this->_setInfoOnPgnParser($pgnParser);
        $this->clearCurrentLine();
        $this->setCurrentState(InfoParserResult::NO);
    }

    abstract protected function _setInfoOnPgnParser(PgnParserInterface $pgnParser): void;

    protected function isMaybe(): bool
    {
        return $this->getCurrentState() === InfoParserResult::MAYBE;
    }

    protected function isYes(): bool
    {
        return $this->getCurrentState() === InfoParserResult::YES;
    }

    protected function isNo(): bool
    {
        return $this->getCurrentState() === InfoParserResult::NO;
    }

    protected function isStartOfLine(): bool
    {
        return $this->startOfLine;
    }
}