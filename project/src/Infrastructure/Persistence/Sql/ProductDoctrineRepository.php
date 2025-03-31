<?php

namespace App\Infrastructure\Persistence\Sql;

use App\Domain\Entity\Relational\Product;
use App\Domain\Entity\Relational\Category;
use App\Domain\Repository\Relational\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductDoctrineRepository implements ProductRepositoryInterface
{
	public function __construct(
		private readonly EntityManagerInterface $em
	) {}

	public function createOrUpdate(string $name, float $price, Category $category, bool $flush = false): Product
	{
		$repo = $this->em->getRepository(Product::class);

		$product = $repo->findOneBy(['name' => $name]);

		if ($product) {
			$product->update($price, $category);
		} else {
			$product = new Product($name, $price, $category);
			$this->em->persist($product);
		}

		if ($flush) {
			$this->em->flush();
		}

		return $product;
	}
}