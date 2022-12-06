<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\SudokuValidatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SudokuValidatorCommand extends Command
{
    private SudokuValidatorInterface $sudokuValidator;

    public function __construct(SudokuValidatorInterface $sudokuValidator)
    {
        $this->sudokuValidator = $sudokuValidator;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('filepath');

        if (false === file_exists($filePath) || false === is_readable($filePath)) {
            $output->writeln('<error>Given file does not exist or is not readable</error>');

            return Command::FAILURE;
        }

        if ('csv' !== pathinfo($filePath, PATHINFO_EXTENSION)) {
            $output->writeln('<error>Only csv files are accepted</error>');

            return Command::FAILURE;
        }

        $grid = $this->csvToArray($filePath);

        try {
            $isValid = $this->sudokuValidator->isValid($grid);

            if (true === $isValid) {
                $output->writeln('<info>Given sudoku grid is correct</info>');

                return Command::SUCCESS;
            } else {
                $output->writeln('<error>Given sudoku grid is incorrect</error>');

                return Command::FAILURE;
            }
        } catch (\InvalidArgumentException $e) {
            $output->writeln(sprintf('<error>CRITICAL: %s</error>', $e->getMessage()));

            return Command::FAILURE;
        }
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you validate given csv file with sudoku grid')
            ->setName('sudoku:validator')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Absolute filepath to csv file');
    }

    private function csvToArray(string $csvFilePath): array
    {
        $fileToRead = fopen($csvFilePath, 'r');
        $lines = [];

        while (!feof($fileToRead)) {
            $values = fgetcsv($fileToRead, 1000, ',');
            $lines[] = array_map(static fn(string $elem) => (int)$elem, $values);
        }

        fclose($fileToRead);

        return $lines;
    }
}