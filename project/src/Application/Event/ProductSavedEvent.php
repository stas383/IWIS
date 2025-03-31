<?php

namespace App\Application\Event;

use App\Domain\Entity\Relational\Product;

class ProductSavedEvent
{
	public function __construct(
		public readonly Product $product
	) {}
}