<?php

namespace App\Repository;

use App\Entity\Product;
use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

//todo: Why we dont extend Service Entity repository and manually injecting entity manager?
class CartRepository implements CartService
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    public function addProduct(string $cartId, string $productId): void
    {
        $cart = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if ($cart && $product && !$cart->isFull()) {
            $cart->addProduct($product);
            $this->entityManager->flush();
        }
    }

    public function removeProduct(string $cartId, string $productId): void
    {
        $cart = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if ($cart && $product) {
            $cart->removeProduct($product);
            $this->entityManager->flush();
        }
    }

    public function create(): Cart
    {
        $cart = new \App\Entity\Cart(Uuid::uuid4()->toString());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}