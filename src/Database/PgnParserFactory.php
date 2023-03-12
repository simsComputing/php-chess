<?php

namespace Chess\Database;

use Chess\Database\PgnParser\MovetextParser;
use Chess\File\ReaderFactory;

class PgnParserFactory
{ 
    /**
     * @param string $filePath
     * @return PgnParserInterface
     */
    public static function create(string $filePath): PgnParserInterface
    {
        $moveTextParser = new MovetextParser();
        $fileReaderFactory = new ReaderFactory();
        $infoParsers = [
            $moveTextParser
        ];
        $pgnParser = new PgnParser($filePath, $fileReaderFactory, $infoParsers);
        return $pgnParser;
    }
}