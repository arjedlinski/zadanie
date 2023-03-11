<?php
declare(strict_types=1);

namespace App\Tests\Functional\Controller\Catalog\EditController;


use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class EditControllerFixture extends AbstractFixture
{

    public function load(ObjectManager $manager): void
    {
        $product = new Product('fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', 'Product 1', 1234);
        $manager->persist($product);
        $manager->flush();
    }
}