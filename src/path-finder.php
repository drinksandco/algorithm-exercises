<?php

declare(strict_types=1);

require 'vendor/autoload.php';

if (!function_exists('recurrentCall')) {
    function recurrentCall(array $matrix, int $x, int $y, array $reference, array &$visited): bool {
        if ($reference[0] === $x && $reference[1] === $y) {
            return true;
        }
        $next = $y + 1;
        if (count($matrix[$x]) > $next) {
            if (!isset($visited[$x][$next]) && $matrix[$x][$next] === 0) {
                $visited[$x][$y] = true;
                if (recurrentCall($matrix, $x, $next, $reference, $visited)) {
                    return true;
                }
                $visited[$x][$y] = false;
            }
        }


        $down = $x + 1;
        if (count($matrix) > $down) {
            if (!isset($visited[$down][$y]) && $matrix[$down][$y] === 0) {
                $visited[$x][$y] = true;
                if (recurrentCall($matrix, $down, $y, $reference, $visited)) {
                    return true;
                }
                $visited[$x][$y] = false;
            }
        }

        $prev = $y - 1;
        if (0 <= $prev) {
            if (!isset($visited[$x][$prev]) && $matrix[$x][$prev] === 0) {
                $visited[$x][$y] = true;
                if (recurrentCall($matrix, $x, $prev, $reference, $visited)) {
                    return true;
                }
                $visited[$x][$y] = false;
            }
        }

        $top = $x - 1;
        if (0 <= $top) {
            if (!isset($visited[$top][$y]) && $matrix[$top][$y] === 0) {
                $visited[$x][$y] = true;
                if (recurrentCall($matrix, $top, $y, $reference, $visited)) {
                    return true;
                }
                $visited[$x][$y] = false;
            }
        }

        return false;
    };
}

return static function (array $matrix, array $reference) {
    $walls = [];
    $totalX = count($matrix);
    $totalY = count($matrix[array_key_first($matrix)]);
    for ($x = 0; $x < $totalX; $x++) {
        for ($y = 0; $y < $totalY; $y++) {
            if (1 === $matrix[$x][$y]) {
                $walls[$x][$y] = true;
                continue;
            }

            $visited = [];
            if(false === recurrentCall($matrix, $x, $y, $reference, $visited)) {
                return false;
            }
        }
    }


    // If total walls is equal to a total matrix positions it is unreachable
    $totalWallsX = count($walls);
    $totalWallsY = 0;
    if (isset($walls[array_key_first($matrix)])) {
        $totalWallsY = count($walls[array_key_first($matrix)]);
    }

    if (($totalX + $totalY) === ($totalWallsX + $totalWallsY)) {
        return false;
    }

    return true;
};
