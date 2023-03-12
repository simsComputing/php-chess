<?php 

namespace Chess\File;

interface ReaderInterface
{
    public function nextChar(): ?string;
}