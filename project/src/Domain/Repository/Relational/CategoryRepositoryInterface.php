<?php

namespace App\Domain\Repository\Relational;

use App\Domain\Entity\Relational\Category;

interface CategoryRepositoryInterface
{
	public function findOrCreateByName(string $name): Category;
}