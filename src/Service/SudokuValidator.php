<?php
declare(strict_types=1);

namespace App\Service;

final class SudokuValidator implements SudokuValidatorInterface
{
    public function isValid(array $grid): bool
    {
        $n = count($grid);
        $square = (int)sqrt($n);

        $lengthOfColumns = array_map(static fn(array $row) => count($row), $grid);
        $uniqueLengthOfColumns = array_unique($lengthOfColumns);
        if (count($uniqueLengthOfColumns) > 1) {
            throw new \InvalidArgumentException('All columns should have the same length');
        }

        if (($square ** 2) !== $n) {
            throw new \InvalidArgumentException('Invalid number of rows');
        }

        $numberOfColumns = reset($uniqueLengthOfColumns);
        if ($n !== $numberOfColumns) {
            throw new \InvalidArgumentException('Grid should be a square');
        }

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if (!$this->isMatrixValid($grid, $i, $j)) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function isMatrixValid(array $grid, int $rowIndex, int $colIndex): bool
    {
        $square = sqrt(count($grid));

        return $this->areValuesInRowValid($grid, $rowIndex)
            && $this->areValuesInColumnValid($grid, $colIndex)
            && $this->areValuesInBoxValid($grid, $rowIndex - $rowIndex % $square, $colIndex - $colIndex % $square);

    }

    private function areValuesInColumnValid($grid, $colIndex): bool
    {
        $n = count($grid);
        $actualValues = [];
        for ($i = 0; $i < $n; $i++) {
            $actualValues[] = $grid[$i][$colIndex];
        }
        sort($actualValues);

        return $actualValues === range(1, $n);
    }

    private function areValuesInRowValid($grid, $rowIndex): bool
    {
        $n = count($grid);
        $actualValues = [];
        for ($i = 0; $i < $n; $i++) {
            $actualValues[] = $grid[$rowIndex][$i];
        }
        sort($actualValues);

        return $actualValues === range(1, $n);
    }


    private function areValuesInBoxValid($grid, $startRowIndex, $startColIndex): bool
    {
        $n = count($grid);
        $square = sqrt($n);

        $actualValues = [];

        for ($i = 0; $i < $square; $i++) {
            for ($j = 0; $j < $square; $j++) {
                $actualValues[] = $grid[$i + $startRowIndex][$j + $startColIndex];
            }
        }

        sort($actualValues);

        return $actualValues === range(1, $n);
    }
}