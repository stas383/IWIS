<?php

namespace App\Infrastructure\Persistence\Mongo;

use App\Domain\Entity\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;

class BufferedMongoFlusher
{
	private array $buffer = [];
	private int $flushLimit = 100;

	public function __construct(
		private readonly DocumentManager $dm
	) {}

	public function persist(Product $product): void
	{
		$this->buffer[] = $product;

		if (count($this->buffer) >= $this->flushLimit) {
			$this->flush();
		}
	}

	public function flush(): void
	{
		foreach ($this->buffer as $product) {
			$this->dm->persist($product);
		}

		$this->dm->flush();
		$this->dm->clear();
		$this->buffer = [];
	}
}