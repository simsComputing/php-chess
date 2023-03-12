<?php

namespace Chess\Tests\Unit\Database\PgnParser;

use Chess\Database\PgnParser\InfoParserResult;
use Chess\Database\PgnParser\MovetextParser;
use Chess\Database\PgnParserInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MovetextParserTest extends TestCase
{
    /**
     * @var PgnParserInterface|MockObject
     */
    private PgnParserInterface $pgnParser;

    public function setUp(): void
    {
        $this->pgnParser = $this->createMock(PgnParserInterface::class);
    }

    /**
     * @dataProvider getDataSet
     * @param [type] $pgnString
     * @param [type] $expected
     * @return void
     */
    public function testInfoOnPgnParser($pgnString, $expected)
    {
        $moveTextParser = new MovetextParser();

        $this->pgnParser->expects($this->once())->method('setMovetext')->with($expected);

        foreach (str_split($pgnString) as $char) {
            if (InfoParserResult::DONE === $moveTextParser->supports($char)) {
                $moveTextParser->setInfoOnPgnParser($this->pgnParser);
                break;
            }
        }
    }

    public function getDataSet()
    {
        return [
            [<<<PGN
[Event "23rd ch-EUR Indiv 2023"]
[Site "Vrnjacka Banja SRB"]
[Date "2023.03.03"]
[Round "1.1"]
[White "Damjanovic,Vuk"]
[Black "Sargissian,G"]
[Result "0-1"]
[WhiteTitle "FM"]
[BlackTitle "GM"]
[WhiteElo "2361"]
[BlackElo "2699"]
[ECO "D38"]
[Opening "QGD"]
[Variation "Ragozin variation"]
[WhiteFideId "980021"]
[BlackFideId "13300881"]
[EventDate "2023.03.03"]

1. d4 d5 2. c4 e6 3. Nf3 Nf6 4. Nc3 Bb4 5. Qa4+ Nc6 6. a3 Bxc3+ 7. bxc3 Ne4 8.
cxd5 exd5 9. c4 O-O 10. e3 dxc4 11. Bxc4 Be6 12. Bb2 Bxc4 13. Qxc4 Na5 14. Qa2
c5 15. dxc5 Qd3 16. Qb1 Nxc5 17. Bd4 Rfc8 18. Qxd3 Nxd3+ 19. Ke2 Nc5 20. Bxc5
Rxc5 21. Rhc1 Rac8 22. Rxc5 Rxc5 23. Nd4 Kf8 24. g4 g6 25. h3 Ke7 26. Kd3 Nc4
27. Rb1 Nd6 28. e4 Ra5 29. Rb3 Kd7 30. f4 b6 31. Rc3 Ra4 32. e5 Nb7 33. f5 Nc5+
34. Ke3 gxf5 35. gxf5 h6 36. f6 h5 37. h4 a6 38. Nf3 Ke6 39. Ke2 Re4+ 40. Re3
Kf5 41. Ng5 Rxe5 42. Nxf7 Rxe3+ 43. Kxe3 Ke6 44. Nd8+ Kxf6 45. Nc6 Kf5 46. Kf3
Nd7 47. Nd4+ Ke5 48. Nc6+ Kd6 49. Nd4 Kd5 50. Ne2 Ke5 51. Ng3 Nf6 52. Ke3 b5 53.
Ne2 Nd5+ 54. Kf3 a5 55. Ng3 b4 56. axb4 a4 57. Ne2 a3 58. Nc1 Nxb4 59. Nb3 a2 0-1
PGN, 
'1. d4 d5 2. c4 e6 3. Nf3 Nf6 4. Nc3 Bb4 5. Qa4+ Nc6 6. a3 Bxc3+ 7. bxc3 Ne4 8. cxd5 exd5 9. c4 O-O 10. e3 dxc4 11. Bxc4 Be6 12. Bb2 Bxc4 13. Qxc4 Na5 14. Qa2 c5 15. dxc5 Qd3 16. Qb1 Nxc5 17. Bd4 Rfc8 18. Qxd3 Nxd3+ 19. Ke2 Nc5 20. Bxc5 Rxc5 21. Rhc1 Rac8 22. Rxc5 Rxc5 23. Nd4 Kf8 24. g4 g6 25. h3 Ke7 26. Kd3 Nc4 27. Rb1 Nd6 28. e4 Ra5 29. Rb3 Kd7 30. f4 b6 31. Rc3 Ra4 32. e5 Nb7 33. f5 Nc5+ 34. Ke3 gxf5 35. gxf5 h6 36. f6 h5 37. h4 a6 38. Nf3 Ke6 39. Ke2 Re4+ 40. Re3 Kf5 41. Ng5 Rxe5 42. Nxf7 Rxe3+ 43. Kxe3 Ke6 44. Nd8+ Kxf6 45. Nc6 Kf5 46. Kf3 Nd7 47. Nd4+ Ke5 48. Nc6+ Kd6 49. Nd4 Kd5 50. Ne2 Ke5 51. Ng3 Nf6 52. Ke3 b5 53. Ne2 Nd5+ 54. Kf3 a5 55. Ng3 b4 56. axb4 a4 57. Ne2 a3 58. Nc1 Nxb4 59. Nb3 a2 0-1']
        ];
    }
}
