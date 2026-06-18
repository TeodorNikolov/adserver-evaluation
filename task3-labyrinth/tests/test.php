<?php

require_once __DIR__ . '/../src/LabyrinthSolver.php';

class TestRunner
{
    public static function assertEqual($expected, $actual, string $message): void
    {
        if ($expected === $actual) {
            echo "PASS: {$message}\n";
        } else {
            echo "FAIL: {$message}\n";
            echo "Expected: {$expected}\n";
            echo "Actual: {$actual}\n\n";
        }
    }

    public static function assertThrows(callable $fn, string $message): void
    {
        try {
            $fn();
            echo "FAIL: {$message}\n";
            echo "Expected exception was not thrown.\n\n";
        } catch (InvalidArgumentException $e) {
            echo "PASS: {$message}\n";
        } catch (Throwable $e) {
            echo "FAIL: {$message}\n";
            echo "Unexpected exception: " . get_class($e) . "\n\n";
        }
    }
}

echo "=== RUNNING TESTS ===\n\n";

/*
|--------------------------------------------------------------------------
| Assignment Example #1
|--------------------------------------------------------------------------
*/

TestRunner::assertEqual(
    11,
    LabyrinthSolver::solution([
        [0,0,0,0,0,0],
        [1,1,1,1,1,0],
        [0,0,0,0,0,0],
        [0,1,1,1,1,1],
        [0,1,1,1,1,1],
        [0,0,0,0,0,0]
    ]),
    "Assignment example #1"
);

/*
|--------------------------------------------------------------------------
| Assignment Example #2
|--------------------------------------------------------------------------
*/

TestRunner::assertEqual(
    7,
    LabyrinthSolver::solution([
        [0,1,1,0],
        [0,0,0,1],
        [1,1,0,0],
        [1,1,1,0]
    ]),
    "Assignment example #2"
);

/*
|--------------------------------------------------------------------------
| Smallest valid maze (2x2)
|--------------------------------------------------------------------------
*/

TestRunner::assertEqual(
    3,
    LabyrinthSolver::solution([
        [0,0],
        [0,0]
    ]),
    "2x2 empty maze"
);

/*
|--------------------------------------------------------------------------
| Requires breaking one wall
|--------------------------------------------------------------------------
*/

TestRunner::assertEqual(
    3,
    LabyrinthSolver::solution([
        [0,1],
        [1,0]
    ]),
    "2x2 maze requiring wall removal"
);

/*
|--------------------------------------------------------------------------
| No wall removal needed
|--------------------------------------------------------------------------
*/

TestRunner::assertEqual(
    5,
    LabyrinthSolver::solution([
        [0,0,0],
        [1,1,0],
        [0,0,0]
    ]),
    "Path exists without removing a wall"
);

/*
|--------------------------------------------------------------------------
| Single obstacle in optimal route
|--------------------------------------------------------------------------
*/

TestRunner::assertEqual(
    5,
    LabyrinthSolver::solution([
        [0,1,0],
        [0,1,0],
        [0,0,0]
    ]),
    "Optimal route may remove one wall"
);

/*
|--------------------------------------------------------------------------
| Input validation tests
|--------------------------------------------------------------------------
*/

TestRunner::assertThrows(
    fn() => LabyrinthSolver::solution([]),
    "Empty map"
);

TestRunner::assertThrows(
    fn() => LabyrinthSolver::solution([
        []
    ]),
    "Empty row"
);

TestRunner::assertThrows(
    fn() => LabyrinthSolver::solution([
        [0,0],
        [0]
    ]),
    "Non-rectangular map"
);

TestRunner::assertThrows(
    fn() => LabyrinthSolver::solution([
        [0,2],
        [0,0]
    ]),
    "Invalid value in map"
);

TestRunner::assertThrows(
    fn() => LabyrinthSolver::solution([
        [0,'1'],
        [0,0]
    ]),
    "Non-integer value in map"
);

echo "\n=== TESTS COMPLETE ===\n";
