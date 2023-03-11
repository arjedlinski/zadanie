<?php

namespace App\Messenger;

class AddProductToCart
{
    //todo: formatting
    public function __construct(public readonly string $cartId, public readonly string $productId) {}
}
