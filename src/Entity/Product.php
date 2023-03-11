<?php

namespace App\Entity;

use App\Entity\ValueObject\NameValueObject;
use App\Entity\ValueObject\PriceValueObject;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Product implements \App\Service\Catalog\Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $createdAt;

    #[ORM\Embedded(class: NameValueObject::class)]
    private NameValueObject $nameValueObject;

    #[ORM\Embedded(class: PriceValueObject::class)]
    private PriceValueObject $priceValueObject;

    public function __construct(string $id, string $name, int $price, \DateTime $dateTime = new \DateTime())
    {
        $this->id = Uuid::fromString($id);
        $this->priceValueObject = new PriceValueObject($price);
        $this->nameValueObject = new NameValueObject($name);
        $this->createdAt = $dateTime;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getName(): string
    {
        return $this->nameValueObject->getName();
    }

    public function getPrice(): int
    {
        return $this->priceValueObject->getPrice();
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getNameValueObject(): NameValueObject
    {
        return $this->nameValueObject;
    }

    public function getPriceValueObject(): PriceValueObject
    {
        return $this->priceValueObject;
    }

    public function setName(string $name): self
    {
        $this->nameValueObject->setName($name);

        return $this;
    }

    public function setPrice(int $price): self
    {
        $this->priceValueObject->setPrice($price);

        return $this;
    }


}
