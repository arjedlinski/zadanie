<?php
declare(strict_types=1);

namespace App\Messenger;

class ChangeProductName
{
    public function __construct
    (
        public readonly string $id,
        public readonly string $name,
    ) {}
}