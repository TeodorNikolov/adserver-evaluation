<?php

declare(strict_types=1);

class Auction
{
    /**
     * @return array{0:string,1:float}
     */
    public static function determineWinner(string $csvFile): array
    {
        if (!file_exists($csvFile)) {
            throw new InvalidArgumentException("File does not exist.");
        }

        $handle = fopen($csvFile, 'r');

        if ($handle === false) {
            throw new RuntimeException("Cannot open file.");
        }

        $highestBid = null;
        $highestAdId = null;

        $secondHighestBid = null;

        $rowNumber = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            if (count($row) < 2) {
                throw new InvalidArgumentException(
                    "Invalid row at line {$rowNumber}"
                );
            }

            $adId = trim($row[0]);
            $bid = trim($row[1]);

            if ($adId === '') {
                throw new InvalidArgumentException(
                    "Empty ad_id at line {$rowNumber}"
                );
            }

            if (!is_numeric($bid)) {
                throw new InvalidArgumentException(
                    "Invalid bid at line {$rowNumber}"
                );
            }

            $bid = (float)$bid;

            if ($highestBid === null || $bid > $highestBid) {
                $secondHighestBid = $highestBid;

                $highestBid = $bid;
                $highestAdId = $adId;
            } elseif (
                $secondHighestBid === null ||
                $bid > $secondHighestBid
            ) {
                $secondHighestBid = $bid;
            }
        }

        fclose($handle);

        if ($highestBid === null) {
            throw new InvalidArgumentException("CSV file is empty.");
        }

        if ($secondHighestBid === null) {
            throw new InvalidArgumentException(
                "At least two bids are required."
            );
        }

        return [$highestAdId, $secondHighestBid];
    }
}
