<?php

declare(strict_types=1);

namespace Test\Algorithms;

use Generator;
use PHPUnit\Framework\TestCase;

class PathFinderTest extends TestCase
{
    private mixed $pathFinder;

    protected function setUp(): void
    {
        $this->pathFinder = require 'src/path-finder.php';
    }

    /** @dataProvider getMatrixWithUnexpectedReferences */
    public function testItCanFindAnyUnreachablePathsToGivenPositionInAMatrix(array $matrix, array $reference): void
    {
        $sut = $this->pathFinder;

        $this->assertFalse($sut($matrix, $reference));
    }


    /** @dataProvider getMatrixWithReachableReferences */
    public function testItCanFindAnyReachablePathsToGivenPositionInAMatrix(array $matrix, array $reference): void
    {
        $sut = $this->pathFinder;

        $this->assertTrue($sut($matrix, $reference));
    }

    public function getMatrixWithUnexpectedReferences(): Generator
    {
        yield 'A matrix with all 1s' => [
            [
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 1],
            ],
            [1, 4],
        ];
        yield 'A matrix with a 1 in the reference' => [
            [
                [1, 1, 0, 0, 1, 1],
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 1],
            ],
            [1, 4],
        ];
        yield 'A matrix with an unreachable path' => [
            [
                [0, 1, 0, 0, 0, 0],
                [0, 1, 0, 0, 1, 0],
                [0, 1, 1, 1, 0, 1],
                [0, 0, 0, 0, 0, 1],
                [0, 1, 0, 1, 0, 1],
            ],
            [1, 4],
        ];
        yield 'unreachable path with different many walls' => [
            [
                [0, 1, 0, 1, 1, 0],
                [0, 1, 0, 1, 0, 0],
                [0, 1, 1, 1, 0, 1],
                [0, 0, 1, 0, 0, 1],
                [1, 0, 0, 0, 1, 1],
            ],
            [1, 4]
        ];
        yield 'Unreachable path with two 0s in the middle' => [
            [
                [0, 0, 0, 0, 0, 0],
                [0, 1, 1, 1, 1, 0],
                [0, 1, 0, 0, 1, 0],
                [0, 1, 1, 1, 1, 0],
                [0, 0, 0, 0, 0, 0],
            ],
            [0, 4]
        ];
        yield 'reachable path with all 0s' => [
            [
                [0, 1, 0, 0, 1, 0],
                [0, 1, 1, 1, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
            ],
            [2, 4]
        ];
        yield 'reachable path with all 0s 1' => [
            [
                [0, 0, 0, 0, 1, 0],
                [0, 0, 0, 0, 1, 0],
                [0, 0, 0, 0, 1, 0],
                [0, 0, 0, 0, 1, 0],
                [0, 0, 0, 0, 1, 0],
            ],
            [0, 0]
        ];
        yield 'A matrix with a jail in the reference' => [
            [
                [0, 0, 0, 0, 0, 0],
                [0, 1, 1, 1, 1, 0],
                [0, 1, 0, 0, 1, 0],
                [0, 1, 1, 1, 1, 0],
                [0, 0, 0, 0, 0, 0],
            ],
            [0, 0],
        ];
    }

    public function getMatrixWithReachableReferences(): Generator
    {
        yield 'reachable path with all 0s until given reference' => [
            [
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 1],
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 1],
            ],
            [0, 4]
        ];
        yield 'reachable path with all 1s before given reference' => [
            [
                [1, 1, 1, 1, 1, 1],
                [1, 1, 1, 1, 1, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
            ],
            [3, 4]
        ];
        yield 'reachable path with all 0s' => [
            [
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
            ],
            [1, 4]
        ];
        yield 'reachable path with many walls' => [
            [
                [0, 1, 0, 0, 0, 0],
                [0, 1, 0, 0, 0, 0],
                [0, 1, 1, 1, 0, 1],
                [0, 0, 0, 1, 0, 1],
                [1, 1, 0, 0, 0, 1],
            ],
            [0, 5]
        ];
    }

}
