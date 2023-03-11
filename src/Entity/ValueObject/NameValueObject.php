<?php
declare(strict_types=1);

namespace App\Entity\ValueObject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class NameValueObject
{
    public function __construct
    (
        #[Assert\NotBlank(allowNull: false)]
        #[Assert\Length(max: 255, maxMessage: 'Name length max 255')]
        #[ORM\Column(type: 'string')]
        private ?string $name,
    ){}

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}