# Escape a Labyrinth

## Overview

This project solves the "Escape a Labyrinth" problem using pure PHP (no frameworks, no external libraries).

You are given a 2D grid (matrix):

- `0` = open cell (walkable)
- `1` = wall (blocked)

You start at the **top-left corner (0,0)** and must reach the **bottom-right corner (n-1, m-1)**.

### Special rule:
You are allowed to remove **at most one wall** during the journey.

---

## Objective

Return the **shortest path length**, including:

- starting cell
- ending cell
- all steps in between

Movement is allowed only in:
- up
- down
- left
- right

(no diagonal movement)

---

## Approach

We use **Breadth-First Search (BFS)** with an extended state:
(row, col, wall_used)


Where:
- `wall_used = 0` → no wall has been removed yet
- `wall_used = 1` → one wall has already been removed

---

## Key Idea

Each position is tracked twice:

- visited without using wall removal
- visited after using wall removal

We store shortest distances in a 3D structure:

```bash
dist[row][col][wall_used]
```


This ensures we always find the optimal path.

---

## Complexity

- Time Complexity: **O(n × m × 2)**
- Space Complexity: **O(n × m × 2)**

Where:
- n = number of rows
- m = number of columns

---

## How to Run

Run the solution file:

```bash
php solve.php
```

Example:

Input

[
    [0,0,0,0,0,0],
    [1,1,1,1,1,0],
    [0,0,0,0,0,0],
    [0,1,1,1,1,1],
    [0,1,1,1,1,1],
    [0,0,0,0,0,0]
]

Output

11

## Assumptions

- Grid is always valid and rectangular
- Start and end cells are always 0
- At most one wall can be removed
- A valid path always exists