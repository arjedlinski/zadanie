<?php
declare(strict_types=1);

namespace App\Entity\ValueObject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class PriceValueObject
{
    public function __construct
    (
        #[Assert\Positive]
        #[ORM\Column(type: 'integer')]
        private ?int $price,
    ){}

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }
}