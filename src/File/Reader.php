<?php 

namespace Chess\File;

use Chess\Exception\SystemException;

class Reader implements ReaderInterface
{
    private $fileResource;

    public function __construct(string $filePath)
    {
        if (!is_readable($filePath)) {
            throw new SystemException('Could not find file with path or file is not readable' . $filePath);
        }

        if (false === $resource = fopen($filePath, 'r')) {
            throw new SystemException('Could not open file with filepath ' . $filePath);
        }

        $this->fileResource = $resource;
    }

    public function nextChar(): ?string
    {
        $char = fgetc($this->fileResource);

        if ($char === false) {
            return null;
        }

        return (string)$char;
    }
}