# Adcash Backend Developer Evaluation

This repository contains my solutions for the Adcash Backend Developer evaluation tasks.

## Tasks

### Task 1 – Advertising Bid Auction

A command-line application that implements a second-price advertising auction.

Features:

- Processes CSV files containing advertisement IDs and bids.
- Determines the winning advertisement (highest bid).
- Returns the second-highest bid as the auction price.
- Handles files containing up to 10,000 rows.
- Includes input validation and error handling.
- Includes automated tests covering normal and edge cases.

Location:

```text
task1-auction/
```

Documentation:

```text
task1-auction/README.md
```

---

### Task 2 – Word Frequency Counter

A REST API that:

- Accepts text submissions via HTTP POST requests.
- Counts word frequencies across multiple requests.
- Provides endpoints to retrieve all word frequencies or the count of a specific word.
- Supports persistent storage using a JSON file.
- Uses file locking (`flock`) to ensure safe concurrent access.
- Includes PHPUnit test coverage.

Location:

```text
task2-word-counter/
```

Documentation:

```text
task2-word-counter/README.md
```

---

### Task 3 – Escape a Labyrinth

A PHP implementation that finds the shortest path through a labyrinth while allowing the removal of at most one wall.

Features:

- Breadth-First Search (BFS) implementation.
- Input validation.
- Edge-case handling.
- Automated tests.
- Complexity analysis and documentation.

Location:

```text
task3-labyrinth/
```

Documentation:

```text
task3-labyrinth/README.md
```

---

## Requirements

- PHP 8.1+
- Composer (required for Task 2)

## Running the Solutions

Refer to the README file inside each task directory for setup instructions, usage examples, testing information, assumptions, and implementation details.

## Repository Structure

```text
repository/
├── task1-auction/
│   ├── src/
│   ├── tests/
│   ├── auction.php
│   └── README.md
├── task2-word-counter/
│   ├── public/
│   ├── src/
│   ├── storage/
│   ├── tests/
│   └── README.md
├── task3-labyrinth/
│   ├── src/
│   ├── tests/
│   ├── solve.php
│   └── README.md
└── README.md
```

## Notes

The solutions were designed to prioritize:

- Correctness
- Readability
- Input validation
- Error handling
- Performance
- Testability
- Clear documentation

Where appropriate, implementation trade-offs, assumptions, and possible production improvements are documented in the corresponding task README files.
