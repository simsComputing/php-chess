<?php 

namespace Chess\File;

interface ReaderFactoryInterface
{
    public function createReader(string $filePath): ReaderInterface;
}