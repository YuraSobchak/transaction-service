<?php

declare(strict_types=1);

namespace App\UserInterface\Command\Transaction;

use App\Domain\Shared\Service\FileProcessor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'transaction:fee:calculate',
    description: 'Command to calculate fees for transactions',
)]
final class CalculateTransactionFeeCommand extends Command
{
    private const FILE_NAME = 'file';

    public function __construct(private readonly FileProcessor $processor)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(self::FILE_NAME, InputArgument::REQUIRED, 'Input file name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument(self::FILE_NAME);

        $fees = $this->processor->processTransactions($filename);
        foreach ($fees as $fee) {
            $output->writeln((string)$fee);
        }

        return Command::SUCCESS;
    }
}
