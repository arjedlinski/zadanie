<?php

namespace App\Messenger;

use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ChangeProductNameHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ProductService $service) { }

    public function __invoke(ChangeProductName $command): void
    {
        $this->service->changeName($command->id, $command->name);
    }
}