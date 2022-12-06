# Sudoku grid validator

## Requirements
- PHP 7.4 (PHP 8.0+ strongly recommended)
- Composer installed (https://getcomposer.org/)

## Installation
```
composer install
```

### How to use

```
php bin/console sudoku:validator /home/user/projects/sudoku-plus/tests/data/sudoku/valid.csv
php bin/console sudoku:validator /home/user/projects/sudoku-plus/tests/data/sudoku/invalid.csv
```

### How to run tests
```
php bin/phpunit
```
or run separately

```
php bin/phpunit tests/Service/SudokuValidatorTest.php
php bin/phpunit tests/Command/SudokuValidatorCommandTest.php
```

### TODO
- [ ] Docker integration
- [ ] Proper code style enforcement