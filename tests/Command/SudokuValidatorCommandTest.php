<?php
declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class SudokuValidatorCommandTest extends KernelTestCase
{
    public function testSuccessfulExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('sudoku:validator');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filepath' => $kernel->getProjectDir() . '/tests/data/sudoku/valid.csv',
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Given sudoku grid is correct', $output);
    }

    public function testInvalidExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('sudoku:validator');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filepath' => $kernel->getProjectDir() . '/tests/data/sudoku/invalid_values.csv',
        ]);

        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Given sudoku grid is incorrect', $output);
    }
}