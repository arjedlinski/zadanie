<?php

namespace App\Entity;

use App\ResponseBuilder\CartBuilder;
use App\Service\Catalog\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Cart implements \App\Service\Cart\Cart
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\OneToMany(
        mappedBy: 'cart',
        targetEntity: CartProduct::class,
        cascade: [
            'persist',
            'remove'
        ],
        orphanRemoval: true,
    )]
    private Collection $products;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->products = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTotalPrice(): int
    {
        return array_reduce(
            $this->products->toArray(),
            static fn(int $total, CartProduct $cartProduct): int =>
                $total + ($cartProduct->getCount() * $cartProduct->getProduct()->getPriceValueObject()->getPrice()),
            0
        );
    }

    #[Pure]
    public function isFull(): bool
    {
        $items = array_reduce(
            $this->products->toArray(),
            static fn(int $total, CartProduct $cartProduct): int =>
                $total + $cartProduct->getCount(),
            0
        );

        return $items >= self::CAPACITY;
    }

    public function getProducts(): iterable
    {
        return $this->products->getIterator();
    }

    public function addProduct(\App\Entity\Product $product): void
    {
        $cartProduct = $this->getCartProductFromProduct($product);

        if ($cartProduct) {
            $cartProduct->increaseCount();

            return;
        }

        $this->products->add(new CartProduct($product, $this));
    }

    public function removeProduct(\App\Entity\Product $product): void
    {
        $cartProduct = $this->getCartProductFromProduct($product);

        if (!$cartProduct) {
            return;
        }

        if ($cartProduct->getCount() < 2) {
            $this->products->removeElement($cartProduct);
        } else {
            $cartProduct->decreaseCount();
        }
    }

    private function getCartProductFromProduct(Product $product): ?CartProduct
    {
        foreach ($this->products as $cartProduct) {
            if ($cartProduct->getProduct() === $product) {
                return $cartProduct;
            }
        }

        return null;
    }
}
