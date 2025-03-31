<?php
namespace App\Domain\Repository;

use App\Domain\Entity\Document\Product;


interface ProductRepositoryInterface
{
	public function save(Product $product, bool $flush = false): void;

	/**
	 * @return Product[]
	 */
	public function findByStatus(string $status): array;
}