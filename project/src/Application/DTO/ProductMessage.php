<?php
namespace App\Application\DTO;


class ProductMessage
{
	public function __construct(
		public readonly string $name,
		public readonly float $price,
		public readonly string $category
	) {}
}