# Labyrinth Solver

## Overview

This application solves a labyrinth represented as a matrix of `0`s and `1`s, where:

* `0` represents a passable cell.
* `1` represents a wall.
* The entrance is located at the top-left corner `(0,0)`.
* The exit is located at the bottom-right corner `(w-1,h-1)`.

The objective is to find the length of the shortest path from the entrance to the exit while being allowed to remove **at most one wall**.

The path length is defined as the total number of cells visited, including both the start and end positions.

---

## Project Structure

```text
project/
├── src/
│   └── LabyrinthSolver.php
├── tests/
│   └── test.php
├── solve.php
└── README.md
```

### File Descriptions

| File                      | Description                                                   |
| ------------------------- | ------------------------------------------------------------- |
| `src/LabyrinthSolver.php` | Contains the BFS-based labyrinth solver implementation.       |
| `tests/test.php`          | Contains functional and validation tests for the solver.      |
| `solve.php`               | Command-line example demonstrating how to execute the solver. |
| `README.md`               | Project documentation and usage instructions.                 |

---

## Approach

The solution uses **Breadth-First Search (BFS)**.

Since every move has the same cost, BFS guarantees the shortest path in an unweighted graph.

To support removing a wall, each position is treated as two distinct states:

* Cell reached without removing a wall.
* Cell reached after removing a wall.

This allows the algorithm to correctly distinguish between:

```text
(row, column, wallRemoved = false)
```

and

```text
(row, column, wallRemoved = true)
```

which represent different future possibilities.

The BFS state is represented as:

```text
(row, column, wallRemoved)
```

where:

* `row` and `column` identify the current position.
* `wallRemoved` indicates whether the wall-removal opportunity has already been used.

---

## Algorithm

1. Start BFS from the entrance `(0,0)`.
2. Maintain a queue of states:

```text
(row, column, wallRemoved)
```

3. Explore neighboring cells in the four cardinal directions:

   * Up
   * Down
   * Left
   * Right

4. If a wall is encountered:

   * Continue only if no wall has been removed yet.
   * Mark the wall-removal state as used.

5. Track distances using:

```text
dist[row][column][wallRemoved]
```

6. Return the minimum distance recorded for the destination cell.

---

## Time and Space Complexity

Let:

```text
R = number of rows
C = number of columns
```

Each cell can be visited in two states:

```text
wallRemoved = 0
wallRemoved = 1
```

### Time Complexity

```text
O(R × C)
```

### Space Complexity

```text
O(R × C)
```

For the maximum maze size specified in the task:

```text
20 × 20 × 2 = 800 states
```

which is very efficient.

---

## Requirements

* PHP 8.1 or higher

No external dependencies are required.

---

## Running the Example

Execute:

```bash
php solve.php
```

Expected output:

```text
Shortest path length: 11
```

The example uses the first labyrinth provided in the assignment.

---

## Usage

Example:

```php
require_once __DIR__ . '/src/LabyrinthSolver.php';

$map = [
    [0,0,0,0,0,0],
    [1,1,1,1,1,0],
    [0,0,0,0,0,0],
    [0,1,1,1,1,1],
    [0,1,1,1,1,1],
    [0,0,0,0,0,0]
];

$result = LabyrinthSolver::solution($map);

echo "Shortest path length: {$result}" . PHP_EOL;
```

---

## Input Validation

The implementation validates the input before processing.

### Empty maps

Invalid:

```php
[]
```

### Empty rows

Invalid:

```php
[
    []
]
```

### Non-rectangular maps

Invalid:

```php
[
    [0,0],
    [0]
]
```

### Invalid values

Only `0` and `1` are accepted.

Invalid:

```php
[
    [0,2],
    [0,0]
]
```

An `InvalidArgumentException` is thrown when invalid input is detected.

---

## Running Tests

Execute:

```bash
php tests/test.php
```

Example output:

```text
RUNNING

PASS: Assignment example #1
PASS: Assignment example #2
PASS: 2x2 empty maze
PASS: 2x2 maze requiring wall removal
PASS: Path exists without removing a wall
PASS: Optimal route may remove one wall
PASS: Empty map
PASS: Empty row
PASS: Non-rectangular map
PASS: Invalid values
PASS: Non-integer value

DONE
```

---

## Test Coverage

The tests cover:

* Assignment example #1
* Assignment example #2
* Small maze scenarios
* Paths requiring wall removal
* Paths not requiring wall removal
* Empty maps
* Empty rows
* Non-rectangular maps
* Invalid values
* Edge cases and validation scenarios

---

## Assumptions

* The start position `(0,0)` is always passable.
* The destination `(w-1,h-1)` is always passable.
* Movement is limited to cardinal directions.
* Diagonal movement is not allowed.
* At most one wall may be removed.
* The maze dimensions are between 2 and 20.

---

## Possible Improvements

For larger labyrinths or production use, the following enhancements could be considered:

* Return the actual shortest path instead of only its length.
* Support removing `K` walls instead of one.
* Stop the BFS immediately when the destination is reached.
* Add path visualization.
* Integrate the solver into a REST API or service layer.
* Add PHPUnit-based automated tests.

---

## Design Decisions

### Why BFS?

Breadth-First Search was chosen because the labyrinth can be modeled as an unweighted graph where each move has the same cost.

BFS guarantees that the first discovered path to a state is the shortest possible path.

### Why Track Two States Per Cell?

Reaching a cell before removing a wall is different from reaching it after removing a wall.

For example:

```text
(3,4,false)
```

and

```text
(3,4,true)
```

represent different future possibilities and must be treated as separate states.

### Why Use SplQueue?

`SplQueue` provides efficient queue operations and is more suitable for BFS than repeatedly using `array_shift()`, which has linear complexity.

This keeps queue operations efficient throughout the traversal.
