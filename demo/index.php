<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Chess\Database\PgnParserFactory;
use Chess\Game;

$pgnParser = PgnParserFactory::create(__DIR__ . '/data.pgn');
$pgnParser->parse();

$firstGameInfo = $pgnParser->getGames()[0];

$game = new Game(Game::VARIANT_CLASSICAL, Game::MODE_PGN);
$game->loadPgn($firstGameInfo->getMoveText());


foreach ($game->getBoard()->getHistory() as $move) {
    var_dump($move->fen);
}