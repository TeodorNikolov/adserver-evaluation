<?php

require_once __DIR__ . '/../src/Auction.php';

try {

    Auction::determineWinner(
        __DIR__ . '/fixtures/single_bid.csv'
    );

    throw new RuntimeException(
        'Expected exception was not thrown.'
    );

} catch (InvalidArgumentException $e) {

    echo "PASS: Single bid test\n";
}
