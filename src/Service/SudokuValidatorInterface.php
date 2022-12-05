<?php
declare(strict_types=1);

namespace App\Service;

interface SudokuValidatorInterface
{
    public function isValid(array $grid): bool;
}