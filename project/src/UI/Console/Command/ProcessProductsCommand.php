<?php
namespace App\UI\Console\Command;

use App\Application\Event\ProductSavedEvent;
use App\Domain\Repository\ProductRepositoryInterface as MongoProductRepositoryInterface;
use App\Domain\Repository\Relational\ProductRepositoryInterface as SqlProductRepositoryInterface;
use App\Domain\Repository\Relational\CategoryRepositoryInterface;
use Doctrine\ODM\MongoDB\DocumentManager as MongoDocumentManager;
use Doctrine\ORM\EntityManagerInterface as SqlEntityManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(name: 'app:process-products')]
class ProcessProductsCommand extends Command
{
	public function __construct(
		private readonly MongoProductRepositoryInterface $mongoRepo,
		private readonly SqlProductRepositoryInterface $productRepo,
		private readonly CategoryRepositoryInterface $categoryRepo,
		private readonly EventDispatcherInterface $eventDispatcher,
		private readonly SqlEntityManager $sqlEntityManager,
		private readonly MongoDocumentManager $mongoDocumentManager
	) {
		parent::__construct();
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$products = $this->mongoRepo->findByStatus('new');

		if (empty($products)) {
			$output->writeln('<info>No new products to process.</info>');
			return Command::SUCCESS;
		}

		foreach ($products as $index => $mongoProduct) {
			$category = $this->categoryRepo->findOrCreateByName($mongoProduct->getCategory());

			$ormProduct = $this->productRepo->createOrUpdate(
				$mongoProduct->getName(),
				$mongoProduct->getPrice(),
				$category,
				flush: false
			);

			$this->eventDispatcher->dispatch(new ProductSavedEvent($ormProduct));

			$mongoProduct->setStatus('processed');
			$this->mongoRepo->save($mongoProduct, flush: false);

			if ($index % 100 === 0) {
				$this->sqlEntityManager->flush();
				$this->sqlEntityManager->clear();
				$this->mongoDocumentManager->flush();
				$this->mongoDocumentManager->clear();
				$this->categoryRepo->clearCache();
			}
		}

		$this->sqlEntityManager->flush();
		$this->sqlEntityManager->clear();
		$this->mongoDocumentManager->flush();
		$this->mongoDocumentManager->clear();

		$output->writeln('<info>Processed ' . count($products) . ' product(s).</info>');
		return Command::SUCCESS;
	}
}
