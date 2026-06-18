# Advertising Bid Auction

## Overview

This application implements a simple **second-price advertising auction**.

Given a CSV file containing advertisement IDs and their bids, the program determines:

- The advertisement with the highest bid (the winner).
- The second-highest bid (the amount paid by the winner).

The solution is implemented as a command-line application and is designed to handle files containing up to **10,000 rows**.

---

## Requirements

- PHP 8.1 or higher

No external dependencies are required.

---

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd task1-auction
```

---

## Project Structure

```text
project/
├── src/
│   └── Auction.php
├── tests/
│   ├── test.php
│   └── fixtures/
│       ├── valid.csv
│       ├── tie.csv
│       ├── decimal_bids.csv
│       ├── invalid_bid.csv
│       ├── single_bid.csv
│       ├── empty.csv
│       ├── invalid_row.csv
│       └── empty_ad_id.csv
├── auction.php
└── README.md
```

---

## Usage

Execute:

```bash
php auction.php <file.csv>
```

Example:

```bash
php auction.php tests/fixtures/valid.csv
```

Output:

```text
4,33
```

---

## Example

Input file:

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

- Ad `4` submitted the highest bid (`33.5`) and wins the auction.
- The second-highest bid is `33`.
- Therefore, the result is:

```text
4,33
```

---

## Algorithm

The solution processes the CSV file row by row using `fgetcsv()`.

During processing it keeps track of:

- The highest bid encountered.
- The second-highest bid encountered.
- The ad ID associated with the highest bid.

No sorting is required.

### Complexity

**Time Complexity**

```text
O(N)
```

**Space Complexity**

```text
O(1)
```

Where `N` is the number of rows in the CSV file.

---

## Input Validation

The application validates:

- File existence.
- File readability.
- Empty files.
- Invalid row formats.
- Empty advertisement IDs.
- Non-numeric bid values.
- Files containing fewer than two bids.

Invalid input results in an appropriate exception and error message.

---

## Running Tests

Execute:

```bash
php tests/test.php
```

Example output:

```text
RUNNING

PASS: Winner determination
PASS: Tie handling
PASS: Decimal bids
PASS: Missing file
PASS: Invalid bid
PASS: Single bid
PASS: Empty CSV
PASS: Invalid row
PASS: Empty ad_id
PASS: Large file (10000 rows)

DONE
```

---

## Test Coverage

The tests cover:

- Winner determination.
- Second-price auction logic.
- Tie handling.
- Decimal bids.
- Missing files.
- Invalid bids.
- Invalid row formats.
- Empty advertisement IDs.
- Empty CSV files.
- Single-bid files.
- Large files containing 10,000 rows.

---

## Assumptions

- Bid values are numeric.
- Advertisement IDs are non-empty strings.
- At least two bids are required.
- In case of equal highest bids, the first encountered advertisement is treated as the winner.
- CSV rows follow the format:

```text
ad_id,bid
```

---

## Possible Improvements

For a production environment, the following improvements could be considered:

- Support CSV headers.
- Configurable tie-breaking rules.
- PHPUnit-based automated testing.
- Logging and monitoring.
- Support additional input formats such as JSON.
- Package the application as a Composer CLI command.
