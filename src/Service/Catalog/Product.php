<?php

namespace App\Service\Catalog;

use App\Entity\ValueObject\NameValueObject;
use App\Entity\ValueObject\PriceValueObject;

interface Product
{
    public function getId(): string;
    public function getName(): string;
    public function getPrice(): int;
    public function getCreatedAt(): \DateTime;
    public function getNameValueObject(): NameValueObject;
    public function getPriceValueObject(): PriceValueObject;

}
