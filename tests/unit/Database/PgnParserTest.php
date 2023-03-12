<?php

namespace Chess\Tests\Unit\Database;

use Chess\Database\PgnParser;
use Chess\Database\PgnParser\InfoParserInterface;
use Chess\File\ReaderFactoryInterface;
use Chess\File\ReaderInterface;
use Chess\Tests\Unit\Database\Fake\FakeInfoParser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

class PgnParserTest extends TestCase
{
    /**
     * @var ReaderFactoryInterface|Stub
     */
    private ReaderFactoryInterface $fileReaderFactory;

    /**
     * @var ReaderInterface|MockObject
     */
    private ReaderInterface $fileReader;

    /**
     * @var InfoParserInterface
     */
    private InfoParserInterface $infoParser;

    public function setUp(): void
    {
        $this->fileReader = $this->createMock(ReaderInterface::class);
        $this->fileReaderFactory = $this->createStub(ReaderFactoryInterface::class);
        $this->fileReaderFactory->method('createReader')->willReturn($this->fileReader);
        $this->infoParser = new FakeInfoParser();
    }

    /**
     * @dataProvider getDataSetForCountGames
     * @param [type] $fileReaderReturn
     * @param [type] $expectedResult
     * @return void
     */
    public function testCountGames($fileReaderReturn, $expectedResult)
    {
        $this->fileReader->expects($this->any())->method('nextChar')->willReturnOnConsecutiveCalls(...$fileReaderReturn);
        $pgnParser = new PgnParser(
            'fakeFilePath',
            $this->fileReaderFactory,
            [$this->infoParser]
        );
        $pgnParser->parse();
        $this->assertEquals($expectedResult, count($pgnParser->getGames()));
    }

    public function getDataSetForCountGames(): array
    {
        return [
            [$this->prepareForCount(4), 4],
            [$this->prepareForCount(34), 34],
            [$this->prepareForCount(104), 104],
            [$this->prepareForCount(1004), 1004],
            // [$this->prepareForCount(4000), 4000],
        ];
    }

    private function prepareForCount(int $count): array
    {
        $arr = [];
        for ($i = 0; $i < $count; $i++) {
            $arr[] = (string)$i;
        }
        return $arr;
    }
}