<?php
declare(strict_types=1);

namespace App\Messenger;

class ChangeProductPrice
{
    public function __construct
    (
        public readonly string $id,
        public readonly int $price
    ) {}
}