<?php
namespace App\Domain\Entity\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'products')]
#[MongoDB\Index(keys: ['status' => 'asc'])]
class Product
{
	#[MongoDB\Id(strategy: 'UUID')]
	private string $id;

	public function __construct(
		#[MongoDB\Field(type: 'string')] private string $name,
		#[MongoDB\Field(type: 'float')] private float $price,
		#[MongoDB\Field(type: 'string')] private string $category,
		#[MongoDB\Field(type: 'string')] private string $status,
		#[MongoDB\Field(type: 'date_immutable')] private \DateTimeImmutable $createdAt
	) {}

	public function getId(): string { return $this->id; }
	public function getName(): string { return $this->name; }
	public function getPrice(): float { return $this->price; }
	public function getCategory(): string { return $this->category; }
	public function getStatus(): string { return $this->status; }
	public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }

	public function setStatus(string $status): void
	{
		$this->status = $status;
	}
}