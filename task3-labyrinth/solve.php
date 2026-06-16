<?php

require_once __DIR__ . '/src/LabyrinthSolver.php';

$map = [
    [0,0,0,0,0,0],
    [1,1,1,1,1,0],
    [0,0,0,0,0,0],
    [0,1,1,1,1,1],
    [0,1,1,1,1,1],
    [0,0,0,0,0,0]
];

try {
    $result = LabyrinthSolver::solution($map);

    echo "Shortest path length: " . $result . PHP_EOL;

} catch (Throwable $e) {
    fwrite(STDERR, "Error: " . $e->getMessage() . PHP_EOL);
    exit(1);
}
