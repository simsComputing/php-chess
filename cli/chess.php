<?php

namespace ChessData\Cli;

require_once __DIR__ . '/../vendor/autoload.php';

use Chess\Game;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

class ModelPlayCli extends CLI
{
    const PROMPT = 'chess > ';

    protected function setup(Options $options)
    {
        $options->setHelp('Play with the AI.');
        $options->registerArgument('model', 'AI model name.', true);
    }

    protected function main(Options $options)
    {
        $game = new Game(Game::MODE_AI, $options->getArgs()[0]);

        do {
            $move = readline(self::PROMPT);
            if ($move === 'fen') {
                echo $game->fen();
            } elseif ($move !== 'quit') {
                $game->play('w', $move);
                $response = $game->response();
                $game->play('b', $response);
                echo self::PROMPT . $game->movetext() . PHP_EOL;
                echo $game->ascii();
            } else {
                break;
            }
        } while (!$game->isMate());
    }
}

$cli = new ModelPlayCli();
$cli->run();