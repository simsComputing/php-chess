<?php

namespace Chess\FEN;

use Chess\Board;
use Chess\Castling\Initialization as CastlingInit;
use Chess\PGN\Symbol;
use Chess\Piece\Bishop;
use Chess\Piece\King;
use Chess\Piece\Knight;
use Chess\Piece\Pawn;
use Chess\Piece\Piece;
use Chess\Piece\Queen;
use Chess\Piece\Rook;
use Chess\Piece\Type\RookType;

/**
 * FEN string to Chess\Board converter.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class StringToBoard
{
    private $string;

    private $fields;

    private $castling;

    private $pieces;

    public function __construct(string $string)
    {
        $this->string = $string;

        $this->fields = array_filter(explode(' ', $this->string));

        $this->castling = CastlingInit::$initialState;

        $this->pieces = [];

        $this->castling();
    }

    public function create(): Board
    {
        $rows = array_filter(explode('/', $this->fields[0]));
        foreach ($rows as $key => $row) {
            $file = 'a';
            $rank = 8 - $key;
            foreach (str_split($row) as $char) {
                if (ctype_lower($char)) {
                    $char = strtoupper($char);
                    $this->pushPiece(Symbol::BLACK, $char, $file.$rank);
                    $file = chr(ord($file) + 1);
                } elseif (ctype_upper($char)) {
                    $this->pushPiece(Symbol::WHITE, $char, $file.$rank);
                    $file = chr(ord($file) + 1);
                } elseif (is_numeric($char)) {
                    $file = chr(ord($file) + $char);
                }
            }
        }
        $board = (new Board($this->pieces, $this->castling))
            ->setTurn($this->fields[1]);

        return $board;
    }

    private function castling()
    {
        switch (true) {
            case !str_contains($this->fields[2], 'K') && !str_contains($this->fields[2], 'Q'):
                $this->castling[Symbol::WHITE][Symbol::CASTLING_SHORT] = false;
                $this->castling[Symbol::WHITE][Symbol::CASTLING_LONG] = false;
                break;
            case !str_contains($this->fields[2], 'K'):
                $this->castling[Symbol::WHITE][Symbol::CASTLING_SHORT] = false;
                break;
            case !str_contains($this->fields[2], 'Q'):
                $this->castling[Symbol::WHITE][Symbol::CASTLING_LONG] = false;
                break;
            case !str_contains($this->fields[2], 'k') && !str_contains($this->fields[2], 'q'):
                $this->castling[Symbol::BLACK][Symbol::CASTLING_SHORT] = false;
                $this->castling[Symbol::BLACK][Symbol::CASTLING_LONG] = false;
                break;
            case !str_contains($this->fields[2], 'k'):
                $this->castling[Symbol::BLACK][Symbol::CASTLING_SHORT] = false;
                break;
            case !str_contains($this->fields[2], 'q'):
                $this->castling[Symbol::BLACK][Symbol::CASTLING_LONG] = false;
                break;
            case $this->fields[2] === '-':
                $this->castling[Symbol::WHITE][Symbol::CASTLING_SHORT] = false;
                $this->castling[Symbol::WHITE][Symbol::CASTLING_LONG] = false;
                $this->castling[Symbol::BLACK][Symbol::CASTLING_SHORT] = false;
                $this->castling[Symbol::BLACK][Symbol::CASTLING_LONG] = false;
                break;
            default:
                // do nothing
                break;
        }
    }

    private function pushPiece($color, $char, $square)
    {
        switch ($char) {
            case Symbol::KING:
                $this->pieces[] = new King($color, $square);
                break;
            case Symbol::QUEEN:
                $this->pieces[] = new Queen($color, $square);
                break;
            case Symbol::ROOK:
                if ($color === Symbol::BLACK &&
                    $square === 'a8' &&
                    $this->castling[$color][Symbol::CASTLING_LONG]
                ) {
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_LONG);
                } elseif (
                    $color === Symbol::BLACK &&
                    $square === 'h8' &&
                    $this->castling[$color][Symbol::CASTLING_SHORT]
                ) {
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_SHORT);
                } elseif (
                    $color === Symbol::WHITE &&
                    $square === 'a1' &&
                    $this->castling[$color][Symbol::CASTLING_LONG]
                ) {
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_LONG);
                } elseif (
                    $color === Symbol::WHITE &&
                    $square === 'h1' &&
                    $this->castling[$color][Symbol::CASTLING_SHORT]
                ) {
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_SHORT);
                } else {
                    // in this case it really doesn't matter which RookType is assigned to the rook
                    $this->pieces[] = new Rook($color, $square, RookType::CASTLING_LONG);
                }
                break;
            case Symbol::BISHOP:
                $this->pieces[] = new Bishop($color, $square);
                break;
            case Symbol::KNIGHT:
                $this->pieces[] = new Knight($color, $square);
                break;
            case Symbol::PAWN:
                $this->pieces[] = new Pawn($color, $square);
                break;
            default:
                // do nothing
                break;
        }
    }
}