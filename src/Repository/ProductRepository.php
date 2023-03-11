<?php

namespace App\Repository;

use App\Service\Catalog\Product;
use App\Service\Catalog\ProductProvider;
use App\Service\Catalog\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

//todo: Why we dont extend Service Entity repository and manually injecting entity manager?
class ProductRepository implements ProductProvider, ProductService
{
    private EntityRepository $repository;

    public function __construct
    (
        private EntityManagerInterface $entityManager,
    )
    {
        $this->repository = $this->entityManager->getRepository(\App\Entity\Product::class);
    }

    public function getProducts(int $page = 0, int $count = 3): iterable
    {
        return $this->repository->createQueryBuilder('p')
            ->setMaxResults($count)
            ->setFirstResult($page * $count)
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getTotalCount(): int
    {
        return $this->repository->createQueryBuilder('p')->select('count(p.id)')->getQuery()->getSingleScalarResult();
    }

    public function exists(string $productId): bool
    {
        return $this->repository->find($productId) !== null;
    }

    //todo: I dont see any place that we using return statement;
    public function add(string $name, int $price): Product
    {
        $product = new \App\Entity\Product(Uuid::uuid4(), $name, $price);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    public function remove(string $id): void
    {
        $product = $this->repository->find($id);
        if ($product !== null) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }
    }

    public function changeName(string $id, string $name): void
    {
        $product = $this->repository->find($id);
        $product->setName($name);

        $this->entityManager->flush();
    }

    public function changePrice(string $id, int $price): void
    {
        $product = $this->repository->find($id);
        $product->setPrice($price);

        $this->entityManager->flush();
    }
}
