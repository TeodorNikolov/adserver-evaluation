<?php

require_once __DIR__ . '/../src/Auction.php';

try {
    Auction::determineWinner(
        __DIR__ . '/fixtures/invalid_bid.csv'
    );

    throw new RuntimeException(
        'Expected exception was not thrown.'
    );

} catch (InvalidArgumentException $e) {
    echo "PASS: Invalid bid test\n";
}
