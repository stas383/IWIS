<?php

namespace App\UI\Console\Command;

use App\Application\Command\ImportProductCommand;
use App\Application\DTO\ProductMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'app:load-test')]
class LoadTestCommand extends Command
{
	public function __construct(
		private readonly MessageBusInterface $bus
	) {
		parent::__construct();
	}

	protected function configure(): void
	{
		$this
			->setDescription('Dispatches a large number of test products to the message queue')
			->addOption('count', 'c', InputOption::VALUE_OPTIONAL, 'Number of products to dispatch', 5000);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$count = (int) $input->getOption('count');
		$output->writeln("<info>Sending $count products to the queue...</info>");

		for ($i = 1; $i <= $count; $i++) {
			$dto = new ProductMessage(
				"Product $i",
				rand(100, 500) / 1.1,
				"Category " . ($i % 5 + 1)
			);

			$this->bus->dispatch(new ImportProductCommand($dto));

			if ($i % 500 === 0) {
				$output->writeln("Dispatched $i products...");
			}
		}

		$output->writeln("<info>All $count products have been dispatched.</info>");

		return Command::SUCCESS;
	}
}
