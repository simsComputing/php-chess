<?php

namespace Chess\Database;

use Chess\Database\PgnParser\InfoParserInterface;
use Chess\Database\PgnParser\InfoParserResult;
use Chess\File\ReaderFactoryInterface;
use Chess\File\ReaderInterface;
use Chess\Game;

class PgnParser implements PgnParserInterface
{
    private ReaderInterface $fileReader;

    private array $games = [];

    private GameInfo $currentGame;

    private array $infoParsers;

    public function __construct(
        string $filePath,
        ReaderFactoryInterface $fileReaderFactory,
        array $infoParsers
    ) {
        $this->fileReader = $fileReaderFactory->createReader($filePath);
        $this->initGame();
        $this->infoParsers = $infoParsers;
    }

    public function parse(): void
    {
        while (null !== $char = $this->fileReader->nextChar()) {
            /** @var InfoParserInterface $infoParser */
            foreach ($this->infoParsers as $infoParser) {
                $result = $infoParser->supports($char);
                if ($result === InfoParserResult::DONE) {
                    $infoParser->setInfoOnPgnParser($this);
                }
            }
        }
    }

    public function setEvent(string $event): void
    {
        // NOT IMPLEMETED YET
    }

    public function setMovetext(string $moveText): void
    {
        $this->currentGame->setMoveText($moveText);
        $this->registerGame();
        $this->initGame();
    }

    private function initGame(): void
    {
        $this->currentGame = new GameInfo();
    }

    private function registerGame(): void
    {
        $this->games[] = $this->currentGame;
    }

    public function getGames(): array
    {
        return $this->games;
    }
}

