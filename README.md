# Adcash Backend Developer Evaluation

This repository contains my solutions for the Adcash Backend Developer evaluation tasks.

## Tasks

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
- Composer (required for Task 2 tests)

## Running the Solutions

Refer to the README file inside each task directory for detailed setup and usage instructions.

## Notes

The solutions were designed to prioritize:

- Correctness
- Readability
- Input validation
- Error handling
- Testability
- Clear documentation

Where appropriate, implementation trade-offs and potential production improvements are documented in the corresponding task README files.
