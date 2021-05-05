<?php

namespace Chess\ML\Supervised\Regression\Labeller;

use Chess\AbstractSnapshot;
use Chess\Heuristic\Picture\Standard as StandardHeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\ML\Supervised\Regression\Labeller\LinearCombinationLabeller;

/**
 * LinearCombination snapshot.
 *
 * @author Jordi Bassagañas
 * @license GPL
 * @see https://github.com/programarivm//blob/master/src/AbstractSnapshot.php
 */
class LinearCombinationSnapshot extends AbstractSnapshot
{
    public function take(): array
    {
        foreach ($this->moves as $move) {
            $this->board->play(Convert::toStdObj(Symbol::WHITE, $move[0]));
            if (isset($move[1])) {
                $this->board->play(Convert::toStdObj(Symbol::BLACK, $move[1]));
            }
            $heuristicPicture = new StandardHeuristicPicture($this->board->getMovetext());
            $this->snapshot[] = (new LinearCombinationLabeller($heuristicPicture))->label();
        }
        $this->normalize();

        return $this->snapshot;
    }
}