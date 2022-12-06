# Sudoku grid validator

### to validate given csv file execute command:

```
php bin/console sudoku:validator /home/user/projects/sudoku-plus/tests/data/sudoku/valid.csv
php bin/console sudoku:validator /home/user/projects/sudoku-plus/tests/data/sudoku/invalid.csv
```

### to run unit tests for Sudoku validator execute
```
php bin/phpunit tests/Service/SudokuValidatorTest.php
```


### to run integration tests for command validation execute
```
php bin/phpunit tests/Command/SudokuValidatorCommandTest.php
```

### TODO
- [ ] Docker integration
- [ ] Proper code style enforcement