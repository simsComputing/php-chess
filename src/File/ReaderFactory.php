<?php 

namespace Chess\File;

class ReaderFactory implements ReaderFactoryInterface
{
    public function createReader(string $filePath): ReaderInterface
    {
        return new Reader($filePath);
    }
}
