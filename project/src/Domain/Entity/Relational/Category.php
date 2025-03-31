<?php

namespace App\Domain\Entity\Relational;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'category')]
class Category
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(type: 'string', unique: true)]
	private string $name;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	public function getId(): int { return $this->id; }

	public function getName(): string { return $this->name; }
}