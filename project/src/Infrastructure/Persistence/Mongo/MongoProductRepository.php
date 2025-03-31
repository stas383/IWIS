<?php
namespace App\Infrastructure\Persistence\Mongo;

use App\Domain\Entity\Document\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

class MongoProductRepository implements ProductRepositoryInterface
{
	public function __construct(
		private readonly DocumentManager $dm
	) {}

	public function save(Product $product, bool $flush = false): void
	{
		$this->dm->persist($product);
		if ($flush) {
			$this->dm->flush();
		}
	}

	public function findByStatus(string $status): array
	{
		return $this->dm
			->getRepository(Product::class)
			->findBy(['status' => $status]);
	}
}