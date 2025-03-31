<?php
namespace App\UI\Http\Controller;


use App\Application\Command\ImportProductCommand;
use App\Application\DTO\ProductMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductImportController extends AbstractController
{
	#[Route('/api/products', name: 'import_products', methods: ['POST'])]
	public function __invoke(Request $request, MessageBusInterface $bus): JsonResponse
	{
		$data = json_decode($request->getContent(), true);

		if (!is_array($data)) {
			return $this->json(['error' => 'Invalid JSON format'], 400);
		}

		foreach ($data as $item) {
			if (!isset($item['name'], $item['price'], $item['category'])) {
				continue; // пропускаємо невалідні товари
			}

			$product = new ProductMessage(
				$item['name'],
				(float) $item['price'],
				$item['category']
			);

			$command = new ImportProductCommand($product);
			$bus->dispatch($command);
		}

		return $this->json(['status' => 'queued'], 202);
	}
}