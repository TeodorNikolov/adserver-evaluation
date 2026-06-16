<?php

require_once __DIR__ . '/../src/Auction.php';

$result = Auction::determineWinner(
    __DIR__ . '/fixtures/tie.csv'
);

if ($result !== ['1', 33.0]) {
    throw new RuntimeException('Tie test failed.');
}

echo "PASS: Tie test\n";
