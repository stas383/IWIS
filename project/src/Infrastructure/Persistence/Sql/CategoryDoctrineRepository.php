<?php

namespace App\Infrastructure\Persistence\Sql;

use App\Domain\Entity\Relational\Category;
use App\Domain\Repository\Relational\CategoryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class CategoryDoctrineRepository implements CategoryRepositoryInterface
{
	private array $categoryCache = [];

	public function __construct(
		private readonly EntityManagerInterface $em
	) {}

	public function findOrCreateByName(string $name): Category
	{
		if (isset($this->categoryCache[$name])) {
			return $this->categoryCache[$name];
		}

		$category = $this->em->getRepository(Category::class)
			->findOneBy(['name' => $name]);

		if (!$category) {
			$category = new Category($name);
			$this->em->persist($category);
		}

		$this->categoryCache[$name] = $category;

		return $category;
	}

	public function clearCache(): void
	{
		$this->categoryCache = [];
	}
}