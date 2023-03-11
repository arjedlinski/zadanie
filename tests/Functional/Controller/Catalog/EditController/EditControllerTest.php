<?php
declare(strict_types=1);

namespace App\Tests\Functional\Controller\Catalog\EditController;

use App\Tests\Functional\WebTestCase;

class EditControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new EditControllerFixture());
    }

    public function test_change_product_name(): void
    {
        $this->client->request('PATCH', '/products/fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', [
            'name' => 'Test name 1',
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');

        $response = $this->getJsonResponse();

        self::assertSame('Test name 1', $response['products'][0]['name']);
    }
    public function test_change_product_price(): void
    {
        $this->client->request('PATCH', '/products/fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', [
            'price' => 1111,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();

        self::assertCount(1, $response['products']);
        self::assertSame(1111, $response['products'][0]['price']);
    }
    public function test_change_product_name_and_price(): void
    {
        $this->client->request('PATCH', '/products/fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', [
            'name' => 'Test name 1',
            'price' => 1111,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();

        self::assertCount(1, $response['products']);
        self::assertSame('Test name 1', $response['products'][0]['name']);
        self::assertSame(1111, $response['products'][0]['price']);
    }
}