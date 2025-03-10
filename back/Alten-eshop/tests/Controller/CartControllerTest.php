<?php

namespace App\Tests\Controller;

use App\Controller\CartController;
use App\Domain\CartDomain;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartControllerTest extends WebTestCase
{
    public function testAddToCartNominalTest(): void
    {
        $user = $this->createMock(User::class);
        $product = $this->createMock(Product::class);
        $cartDomain = $this->createMock(CartDomain::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $controller = new CartController($cartDomain);


        $cartDomain->expects($this->once())->method('addProductToCart')->with($user, $product);

        $response = $controller->addToCart($user, $product, $entityManager);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode(['message' => 'Produit ajouté au panier']), $response->getContent());


    }
}