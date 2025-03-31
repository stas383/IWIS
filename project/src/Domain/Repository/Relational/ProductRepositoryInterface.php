<?php

namespace App\Domain\Repository\Relational;

use App\Domain\Entity\Relational\Category;
use App\Domain\Entity\Relational\Product;

interface ProductRepositoryInterface
{
	public function createOrUpdate(string $name, float $price, Category $category, bool $flush = false): Product;
}