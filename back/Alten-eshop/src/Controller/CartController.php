<?php

namespace App\Controller;

use App\Domain\CartDomain;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/carts', name: 'api_cart_')]
class CartController extends AbstractController
{
    private CartDomain $cartDomain;
    public function __construct(CartDomain $cartDomain){
        $this->cartDomain = $cartDomain;
    }
    #[Route('/{id}/addToCart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(#[CurrentUser] ?UserInterface $user, Product $product, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non authentifié'], Response::HTTP_UNAUTHORIZED);
        }

        $this->cartDomain->addProductToCart($user, $product);


        return new JsonResponse(['message' => 'Produit ajouté au panier'], Response::HTTP_OK);
    }

}
