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

        for ($colIndex = 0; $colIndex < $n; $colIndex++) {
            for ($rowIndex = 0; $rowIndex < $n; $rowIndex++) {
                if (!$this->isMatrixValid($grid, $colIndex, $rowIndex)) {
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
        for ($rowIndex = 0; $rowIndex < $n; $rowIndex++) {
            $actualValues[] = $grid[$rowIndex][$colIndex];
        }
        sort($actualValues);

        return $actualValues === range(1, $n);
    }

    private function areValuesInRowValid($grid, $rowIndex): bool
    {
        $n = count($grid);
        $actualValues = [];
        for ($colIndex = 0; $colIndex < $n; $colIndex++) {
            $actualValues[] = $grid[$rowIndex][$colIndex];
        }
        sort($actualValues);

        return $actualValues === range(1, $n);
    }


    private function areValuesInBoxValid($grid, $startRowIndex, $startColIndex): bool
    {
        $n = count($grid);
        $square = sqrt($n);

        $actualValues = [];

        for ($rowIndex = 0; $rowIndex < $square; $rowIndex++) {
            for ($colIndex = 0; $colIndex < $square; $colIndex++) {
                $actualValues[] = $grid[$rowIndex + $startRowIndex][$colIndex + $startColIndex];
            }
        }

        sort($actualValues);

        return $actualValues === range(1, $n);
    }
}