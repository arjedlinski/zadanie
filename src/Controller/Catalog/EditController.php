<?php
declare(strict_types=1);

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\ChangeProductName;
use App\Messenger\ChangeProductPrice;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\ResponseBuilder\ErrorBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/products/{product}', name: 'product-edit', methods: Request::METHOD_PATCH)]
class EditController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct
    (
        private ErrorBuilder $errorBuilder,
        private readonly ValidatorInterface $validator,
        private readonly EntityManagerInterface $entityManager,
    ) { }

    public function __invoke(?Product $product, Request $request): Response
    {
        if (!$product) {
            throw new NotFoundHttpException();
        }

        if (($request->request->has('name'))) {
            $this->dispatch(new ChangeProductName($product->getId(), $request->get('name')));
        }

        if (($request->request->has('price'))) {
            $this->dispatch(new ChangeProductPrice($product->getId(), (int) $request->get('price')));
        }

        return new Response('', Response::HTTP_ACCEPTED);
    }
}