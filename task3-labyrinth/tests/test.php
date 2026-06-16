<?php

require_once __DIR__ . '/../src/LabyrinthSolver.php';

class TestRunner
{
    public static function assertEqual($expected, $actual, $message)
    {
        if ($expected === $actual) {
            echo "PASS: $message\n";
        } else {
            echo "FAIL: $message\nExpected: $expected Got: $actual\n";
        }
    }
}

// RUN TESTS (this is what you were missing)

$map = [
    [0,0,0,0,0,0],
    [1,1,1,1,1,0],
    [0,0,0,0,0,0],
    [0,1,1,1,1,1],
    [0,1,1,1,1,1],
    [0,0,0,0,0,0]
];

echo "RUNNING\n";

TestRunner::assertEqual(
    11,
    LabyrinthSolver::solution($map),
    "Labyrinth test"
);

echo "DONE\n";
