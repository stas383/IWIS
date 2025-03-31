<?php

namespace App\Domain\Entity\Relational;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product')]
class Product
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(type: 'string')]
	private string $name;

	#[ORM\Column(type: 'float')]
	private float $price;

	#[ORM\ManyToOne(targetEntity: Category::class)]
	#[ORM\JoinColumn(nullable: false)]
	private Category $category;

	public function __construct(string $name, float $price, Category $category)
	{
		$this->name = $name;
		$this->price = $price;
		$this->category = $category;
	}

	public function update(float $price, Category $category): void
	{
		$this->price = $price;
		$this->category = $category;
	}

	public function getId(): int { return $this->id; }

	public function getName(): string
	{
		return $this->name;
	}

	public function getPrice(): float
	{
		return $this->price;
	}

	public function getCategory(): Category
	{
		return $this->category;
	}
}