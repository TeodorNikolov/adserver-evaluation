<?php

require_once __DIR__ . '/../src/Auction.php';

$result = Auction::determineWinner(
    __DIR__ . '/fixtures/valid.csv'
);

if ($result !== ['4', 33.0]) {
    throw new RuntimeException('Winner test failed.');
}

echo "PASS: Winner test\n";
