<?php

namespace App\Application\Command;

use App\Application\DTO\ProductMessage;

class ImportProductCommand
{
	public function __construct(
		public readonly ProductMessage $product
	) {}
}