<?php

require_once __DIR__ . '/../src/Auction.php';

class TestRunner
{
    public static function assertEqual($expected, $actual, string $message): void
    {
        if ($expected === $actual) {
            echo "PASS: {$message}\n";
        } else {
            echo "FAIL: {$message}\n";
            echo "Expected: " . var_export($expected, true) . "\n";
            echo "Actual: " . var_export($actual, true) . "\n\n";
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

echo "RUNNING\n\n";

/*
|--------------------------------------------------------------------------
| Happy path
|--------------------------------------------------------------------------
*/

TestRunner::assertEqual(
    ['4', 33.0],
    Auction::determineWinner(
        __DIR__ . '/fixtures/valid.csv'
    ),
    'Winner is ad 4 and pays second-highest bid'
);

/*
|--------------------------------------------------------------------------
| Tie handling
|--------------------------------------------------------------------------
*/

TestRunner::assertEqual(
    ['1', 33.0],
    Auction::determineWinner(
        __DIR__ . '/fixtures/tie.csv'
    ),
    'Tie handling (first highest bid wins)'
);

/*
|--------------------------------------------------------------------------
| Missing file
|--------------------------------------------------------------------------
*/

TestRunner::assertThrows(
    fn() => Auction::determineWinner(
        __DIR__ . '/fixtures/missing.csv'
    ),
    'Missing file'
);

/*
|--------------------------------------------------------------------------
| Invalid bid
|--------------------------------------------------------------------------
*/

TestRunner::assertThrows(
    fn() => Auction::determineWinner(
        __DIR__ . '/fixtures/invalid_bid.csv'
    ),
    'Invalid bid'
);

/*
|--------------------------------------------------------------------------
| Single bid
|--------------------------------------------------------------------------
*/

TestRunner::assertThrows(
    fn() => Auction::determineWinner(
        __DIR__ . '/fixtures/single_bid.csv'
    ),
    'Single bid'
);

/*
|--------------------------------------------------------------------------
| Empty CSV
|--------------------------------------------------------------------------
*/

TestRunner::assertThrows(
    fn() => Auction::determineWinner(
        __DIR__ . '/fixtures/empty.csv'
    ),
    'Empty CSV'
);

/*
|--------------------------------------------------------------------------
| Invalid row
|--------------------------------------------------------------------------
*/

TestRunner::assertThrows(
    fn() => Auction::determineWinner(
        __DIR__ . '/fixtures/invalid_row.csv'
    ),
    'Invalid row format'
);

/*
|--------------------------------------------------------------------------
| Empty ad_id
|--------------------------------------------------------------------------
*/

TestRunner::assertThrows(
    fn() => Auction::determineWinner(
        __DIR__ . '/fixtures/empty_ad_id.csv'
    ),
    'Empty ad_id'
);

/*
|--------------------------------------------------------------------------
| Decimal bids
|--------------------------------------------------------------------------
*/

TestRunner::assertEqual(
    ['2', 33.5],
    Auction::determineWinner(
        __DIR__ . '/fixtures/decimal_bids.csv'
    ),
    'Decimal bids'
);

/*
|--------------------------------------------------------------------------
| Large file (10000 rows)
|--------------------------------------------------------------------------
*/

$tempFile = tempnam(sys_get_temp_dir(), 'auction_test');

$fp = fopen($tempFile, 'w');

for ($i = 1; $i <= 10000; $i++) {
    fputcsv($fp, [$i, $i]);
}

fclose($fp);

TestRunner::assertEqual(
    ['10000', 9999.0],
    Auction::determineWinner($tempFile),
    'Large file (10000 rows)'
);

unlink($tempFile);

echo "\nDONE\n";
