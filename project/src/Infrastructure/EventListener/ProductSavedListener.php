<?php
namespace App\Infrastructure\EventListener;

use App\Application\Event\ProductSavedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


#[AsEventListener(event: ProductSavedEvent::class)]
readonly class ProductSavedListener
{
	public function __construct(
		#[Autowire(service: 'monolog.logger.product')]
		private LoggerInterface $logger
	) {}

	public function __invoke(ProductSavedEvent $event): void
	{
		$this->logger->info('
		✅ Product saved to MySQL: ' . $event->product->getName());
	}
}