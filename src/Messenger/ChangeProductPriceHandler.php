<?php

namespace App\Messenger;

use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ChangeProductPriceHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ProductService $service) { }

    public function __invoke(ChangeProductPrice $command): void
    {
        $this->service->changePrice($command->id, $command->price);
    }
}