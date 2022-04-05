<?php

namespace Chess\ML\Supervised\Classification;

use Chess\ML\Supervised\AbstractLabeller;
use Chess\PGN\Symbol;

class PermutationLabeller extends AbstractLabeller
{
    protected $permutations;

    public function __construct(array $permutations = [])
    {
        $this->permutations = $permutations;
    }
    
    public function label(array $end)
    {
        $sums = [];
        foreach ($this->permutations as $i => $weights) {
            $sum = 0;
            foreach ($end as $j => $val) {
                $sum += $weights[$j] * $val;
            }
            $sums[$i] = round($sum, 2);
        }

        $max = array_search(max($sums), $sums);
        $min = array_search(min($sums), $sums);

        return [
            Symbol::WHITE => $max,
            Symbol::BLACK => $min,
        ];
    }
}