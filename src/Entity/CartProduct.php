<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class CartProduct
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Product::class, fetch: 'EAGER')]
    private Product $product;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'id')]
    private Cart $cart;

    #[ORM\Column(type: 'integer')]
    private int $count = 1;

    public function __construct(Product $product, Cart $cart)
    {
        $this->product = $product;
        $this->cart = $cart;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function increaseCount(): void
    {
        $this->count++;
    }

    public function decreaseCount(): void
    {
        $this->count--;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}