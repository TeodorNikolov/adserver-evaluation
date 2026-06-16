<?php

require_once __DIR__ . '/../src/Auction.php';

try {
    Auction::determineWinner(
        __DIR__ . '/fixtures/missing.csv'
    );

    throw new RuntimeException(
        'Expected exception was not thrown.'
    );

} catch (InvalidArgumentException $e) {
    echo "PASS: Missing file test\n";
}
