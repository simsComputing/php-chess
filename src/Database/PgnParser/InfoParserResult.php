<?php

namespace Chess\Database\PgnParser;
interface InfoParserResult
{
    const NO = 1;
    const  YES = 3;
    const MAYBE = 2;
    const DONE = 4;
}