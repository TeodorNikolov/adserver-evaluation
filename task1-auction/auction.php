<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Auction.php';

if ($argc !== 2) {
    fwrite(STDERR, "Usage: php auction.php <file.csv>\n");
    exit(1);
}

try {
    [$winnerId, $secondBid] = Auction::determineWinner($argv[1]);

    echo $winnerId . "," . $secondBid . PHP_EOL;

} catch (Throwable $e) {
    fwrite(STDERR, "Error: {$e->getMessage()}" . PHP_EOL);
    exit(1);
}
