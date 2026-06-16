# Advertising Bid Auction

A command-line PHP application that implements a second-price auction.

Given a CSV file containing advertisement IDs and bids, the program determines:

* The winning advertisement (highest bid)
* The price to pay (second-highest bid)

Example input:

```csv
1,0.5
2,33
3,12
4,33.5
```

Output:

```text
4,33
```

Explanation:

* Ad `4` has the highest bid (`33.5`)
* The second-highest bid is `33`
* Therefore ad `4` wins and pays `33`

---

## Requirements

* PHP 8.0+ (developed and tested on PHP 8.5.7)
* No frameworks
* No third-party libraries

Verify your PHP version:

```bash
php -v
```

---

## Project Structure

```text
.
├── auction.php
├── README.md
├── sample.csv
├── src
│   └── Auction.php
└── tests
    ├── WinnerTest.php
    ├── InvalidBidTest.php
    ├── MissingFileTest.php
    ├── SingleBidTest.php
    ├── TieTest.php
    └── fixtures
        ├── valid.csv
        ├── invalid_bid.csv
        ├── single_bid.csv
        └── tie.csv
```

---

## Running the Application

Execute the application and provide a CSV file:

```bash
php auction.php sample.csv
```

Example:

```bash
php auction.php sample.csv
```

Output:

```text
4,33
```

---

## CSV Format

The input CSV file must contain two columns:

```csv
ad_id,bid
```

Example:

```csv
1,0.5
2,33
3,12
4,33.5
```

Rules:

* `ad_id` must not be empty
* `bid` must be numeric
* At least two valid bids are required

---

## Running Tests

Each test can be executed independently.

### Winner Test

```bash
php tests/WinnerTest.php
```

Expected:

```text
PASS: Winner test
```

### Invalid Bid Test

```bash
php tests/InvalidBidTest.php
```

Expected:

```text
PASS: Invalid bid test
```

### Missing File Test

```bash
php tests/MissingFileTest.php
```

Expected:

```text
PASS: Missing file test
```

### Single Bid Test

```bash
php tests/SingleBidTest.php
```

Expected:

```text
PASS: Single bid test
```

### Tie Test

```bash
php tests/TieTest.php
```

Expected:

```text
PASS: Tie test
```

---

## Error Handling

The application validates:

* File existence
* CSV row structure
* Numeric bid values
* Empty input files
* Minimum number of bids

Invalid input results in descriptive exceptions and a non-zero exit code.

---

## Tie Handling

If multiple advertisements share the highest bid, the first advertisement encountered in the CSV file is selected as the winner.

Example:

```csv
1,33
2,33
3,10
```

Output:

```text
1,33
```

---

## Complexity Analysis

Time Complexity:

```text
O(n)
```

Space Complexity:

```text
O(1)
```

The solution processes the CSV file in a single pass and stores only:

* Current highest bid
* Current second-highest bid
* Winning advertisement ID

This allows efficient processing of files containing 10,000 rows and beyond.

---
