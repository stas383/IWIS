<?php

namespace App\Application\CommandHandler;
use App\Application\Command\ImportProductCommand;
use App\Domain\Entity\Document\Product;
use App\Infrastructure\Persistence\Mongo\BufferedMongoFlusher;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ImportProductHandler
{
	public function __construct(
		private readonly BufferedMongoFlusher $bufferedFlusher
	) {}

	public function __invoke(ImportProductCommand $command): void
	{
		$product = new Product(
			name: $command->product->name,
			price: $command->product->price,
			category: $command->product->category,
			status: 'new',
			createdAt: new \DateTimeImmutable()
		);

		$this->bufferedFlusher->persist($product);
	}
}