<?php

class LabyrinthSolver
{
    public static function solution(array $map): int
    {
        if (empty($map) || empty($map[0])) {
            throw new InvalidArgumentException("Invalid map");
        }

        $rows = count($map);
        $cols = count($map[0]);

        // Validate rectangular grid + values
        for ($r = 0; $r < $rows; $r++) {
            if (count($map[$r]) !== $cols) {
                throw new InvalidArgumentException("Non-rectangular map");
            }

            for ($c = 0; $c < $cols; $c++) {
                if ($map[$r][$c] !== 0 && $map[$r][$c] !== 1) {
                    throw new InvalidArgumentException("Map must contain only 0 and 1");
                }
            }
        }

        // dist[r][c][removed]
        $dist = array_fill(
            0,
            $rows,
            array_fill(
                0,
                $cols,
                [PHP_INT_MAX, PHP_INT_MAX]
            )
        );

        // BFS queue: [row, col, wall_removed]
        $queue = new SplQueue();

        // start position
        $dist[0][0][0] = 1;
        $queue->enqueue([0, 0, 0]);

        $directions = [
            [1, 0],
            [-1, 0],
            [0, 1],
            [0, -1]
        ];

        while (!$queue->isEmpty()) {
            [$r, $c, $removed] = $queue->dequeue();

            foreach ($directions as [$dr, $dc]) {
                $nr = $r + $dr;
                $nc = $c + $dc;

                // bounds check
                if ($nr < 0 || $nr >= $rows || $nc < 0 || $nc >= $cols) {
                    continue;
                }

                $newRemoved = $removed;

                // wall encountered
                if ($map[$nr][$nc] === 1) {
                    if ($removed === 1) {
                        continue; // already used wall break
                    }
                    $newRemoved = 1;
                }

                $newDist = $dist[$r][$c][$removed] + 1;

                // relax step (standard BFS shortest path pattern)
                if ($newDist < $dist[$nr][$nc][$newRemoved]) {
                    $dist[$nr][$nc][$newRemoved] = $newDist;
                    $queue->enqueue([$nr, $nc, $newRemoved]);
                }
            }
        }

        $endR = $rows - 1;
        $endC = $cols - 1;

        return min(
            $dist[$endR][$endC][0],
            $dist[$endR][$endC][1]
        );
    }
}
